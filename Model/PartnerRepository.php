<?php
declare(strict_types=1);

namespace Vendor\Partners\Model;

use Vendor\Partners\Api\PartnerRepositoryInterface;
use Vendor\Partners\Api\Data\PartnerInterface;
use Vendor\Partners\Model\ResourceModel\Partner as PartnerResource;
use Vendor\Partners\Model\ResourceModel\Partner\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;

/**
 * Simple repository implementation for Partner.
 *
 * Note: For the test/exercise this uses basic getList() returning collection items.
 * A production implementation would fully implement SearchCriteria handling.
 */
class PartnerRepository implements PartnerRepositoryInterface
{
    private PartnerResource $resource;
    private CollectionFactory $collectionFactory;
    private \Magento\Framework\Api\SearchResultsInterface $searchResults;

    public function __construct(
        PartnerResource $resource,
        CollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResults = $searchResultsFactory->create();
    }

    public function save(PartnerInterface $partner): PartnerInterface
    {
        $this->resource->save($partner);
        return $partner;
    }

    public function getById(int $id): PartnerInterface
    {
        $model = $this->collectionFactory->create()->getItemById($id);
        if (!$model || !$model->getId()) {
            throw new NoSuchEntityException(__('Partner with id %1 does not exist.', $id));
        }
        return $model;
    }

    public function delete(PartnerInterface $partner): bool
    {
        $this->resource->delete($partner);
        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // Minimal implementation: return all items
        $collection = $this->collectionFactory->create();
        return $collection->getItems();
    }
}
