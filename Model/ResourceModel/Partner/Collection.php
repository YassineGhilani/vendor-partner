<?php

declare(strict_types=1);

namespace Vendor\Partners\Model\ResourceModel\Partner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vendor\Partners\Model\Partner as PartnerModel;
use Vendor\Partners\Model\ResourceModel\Partner as PartnerResource;

class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct(): void
    {
        $this->_init(
            PartnerModel::class, 
            PartnerResource::class
        );
    }

    /**
     * Filter collection to active partners only
     *
     * @return $this
     */
    public function addActiveFilter(): self
    {
        $this->addFieldToFilter('is_active', 1);
        return $this;
    }
}
