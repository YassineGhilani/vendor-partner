<?php
declare(strict_types=1);

namespace Vendor\Partners\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;

/**
 * Redirects to edit action for creating a new partner
 */
class NewAction extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Partners::partners';

    public function execute()
    {
        $this->_redirect('*/*/edit');
    }
}
