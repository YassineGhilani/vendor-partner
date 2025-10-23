<?php
declare(strict_types=1);

namespace Vendor\Partners\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Vendor\Partners\Model\PartnerFactory;
use Vendor\Partners\Model\Uploader\Logo as LogoUploader;
use Magento\Framework\Exception\LocalizedException;

/**
 * Processes form save for partner (create/update).
 * Handles uploaded logo via Uploader service.
 */
class Save extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Partners::partners';

    private PartnerFactory $partnerFactory;
    private LogoUploader $logoUploader;

    public function __construct(
        Action\Context $context,
        PartnerFactory $partnerFactory,
        LogoUploader $logoUploader
    ) {
        parent::__construct($context);
        $this->partnerFactory = $partnerFactory;
        $this->logoUploader = $logoUploader;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('*/*/');
        }

        $id = (int)$this->getRequest()->getParam('partner_id');
        $model = $this->partnerFactory->create();
        if ($id) {
            $model->load($id);
        }

        // logo handling:
        try {
            if (isset($_FILES['logo']) && $_FILES['logo']['name'] !== '') {
                $path = $this->logoUploader->saveUploadedFile('logo');
                $data['logo'] = $path;
            } elseif (isset($data['logo']) && is_array($data['logo']) && !empty($data['logo'][0]['name'])) {
                // imageUploader returns structured array when editing
                $data['logo'] = 'partners/' . $data['logo'][0]['name'];
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->_redirect('*/*/edit', ['partner_id' => $id]);
        }

        // Normalize checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('Partner saved.'));
            if ($this->getRequest()->getParam('back')) {
                return $this->_redirect('*/*/edit', ['partner_id' => $model->getId()]);
            }
            return $this->_redirect('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the partner.'));
            return $this->_redirect('*/*/edit', ['partner_id' => $id]);
        }
    }
}
