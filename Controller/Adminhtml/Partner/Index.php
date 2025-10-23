<?php
declare(strict_types=1);

namespace Vendor\Partners\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Renders the grid page.
 */
class Index extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Partners::partners';

    private PageFactory $resultPageFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vendor_Partners::partners');
        $resultPage->getConfig()->getTitle()->prepend(__('Partners'));
        return $resultPage;
    }
}
