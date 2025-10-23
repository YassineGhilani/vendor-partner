<?php
declare(strict_types=1);

namespace Vendor\Partners\Block;

use Magento\Framework\View\Element\Template;
use Vendor\Partners\Model\ResourceModel\Partner\CollectionFactory;

/**
 * Block that returns active partners for frontend display.
 */
class ActivePartners extends Template
{
    private CollectionFactory $collectionFactory;

    public function __construct(Template\Context $context, CollectionFactory $collectionFactory, array $data = [])
    {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return \Vendor\Partners\Model\Partner[]
     */
    public function getActivePartners(): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', 1);
        return $collection->getItems();
    }
}
