<?php
declare(strict_types=1);

namespace Vendor\Partners\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Vendor\Partners\Model\PartnerFactory;

/**
 * Deletes a partner.
 */
class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Partners::partners';

    private PartnerFactory $partnerFactory;

    public function __construct(Action\Context $context, PartnerFactory $partnerFactory)
    {
        parent::__construct($context);
        $this->partnerFactory = $partnerFactory;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('partner_id');
        if ($id) {
            try {
                $model = $this->partnerFactory->create()->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('Partner deleted.'));
                return $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->_redirect('*/*/edit', ['partner_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a partner to delete.'));
        return $this->_redirect('*/*/');
    }
}