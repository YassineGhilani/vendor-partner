<?php
declare(strict_types=1);

namespace Vendor\Partners\Test\Unit\Model\ResourceModel\Partner;

use PHPUnit\Framework\TestCase;
use Vendor\Partners\Model\ResourceModel\Partner\Collection;
use Magento\Framework\Data\Collection\EntityFactory;

class CollectionTest extends TestCase
{
    public function testCollectionClassExtendsAbstractCollection(): void
    {
        $entityFactoryMock = $this->createMock(EntityFactory::class);
        $collection = new Collection($entityFactoryMock);
        $this->assertInstanceOf(Collection::class, $collection);
    }
}
