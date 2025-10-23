<?php
declare(strict_types=1);

namespace Vendor\Partners\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Vendor\Partners\Model\PartnerFactory;

/**
 * Renders edit/new form
 */
class Edit extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Partners::partners';

    private PageFactory $resultPageFactory;
    private PartnerFactory $partnerFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory, PartnerFactory $partnerFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->partnerFactory = $partnerFactory;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('partner_id');
        $model = $this->partnerFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This partner no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Partner') : __('New Partner'));
        return $resultPage;
    }
}
