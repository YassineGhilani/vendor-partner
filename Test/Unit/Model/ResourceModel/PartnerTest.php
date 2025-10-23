<?php
declare(strict_types=1);

namespace Vendor\Partners\Test\Unit\Model\ResourceModel;

use PHPUnit\Framework\TestCase;
use Vendor\Partners\Model\ResourceModel\Partner;

class PartnerTest extends TestCase
{
    public function testMainTableAndIdFieldAreCorrect(): void
    {
        $resourceModel = new Partner();
        $this->assertEquals('vendor_partners', $resourceModel->getMainTable());
        $this->assertEquals('partner_id', $resourceModel->getIdFieldName());
    }

    public function testThrowsExceptionIfTableMissing(): void
    {
        $this->expectException(\RuntimeException::class);
        throw new \RuntimeException('La table vendor_partners est introuvable.');
    }
}
