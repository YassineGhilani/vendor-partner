<?php

declare(strict_types=1);

namespace Vendor\Partners\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Partner extends AbstractDb
{
    const TABLE_NAME = 'vendor_partners';
    const PRIMARY_KEY = 'partner_id'
    /**
     * Initialize table and primary key
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME,self::PRIMARY_KEY);
    }
}