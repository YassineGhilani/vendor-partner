<?php
declare(strict_types=1);

namespace Vendor\Partners\Api;

use Vendor\Partners\Api\Data\PartnerInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Repository interface for Partner entity.
 */
interface PartnerRepositoryInterface
{
    public function save(PartnerInterface $partner): PartnerInterface;
    public function getById(int $id): PartnerInterface;
    public function delete(PartnerInterface $partner): bool;
    /**
     * Return list of partners (partial SearchCriteria implementation).
     * @return PartnerInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
