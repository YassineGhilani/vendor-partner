<?php
declare(strict_types=1);

namespace Vendor\Partners\Test\Integration\Setup;

use PHPUnit\Framework\TestCase;
use Vendor\Partners\Setup\InstallSchema;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchemaTest extends TestCase
{
    public function testInstallCreatesCorrectTable(): void
    {
        $schemaSetup = $this->createMock(SchemaSetupInterface::class);
        $context = $this->createMock(ModuleContextInterface::class);

        $schemaSetup->method('getTable')->willReturn('vendor_partners');

        $schemaSetup->expects($this->once())
            ->method('getConnection')
            ->willReturnSelf();

        $schemaSetup->expects($this->once())
            ->method('newTable')
            ->with('vendor_partners');

        $installSchema = new InstallSchema();
        $installSchema->install($schemaSetup, $context);
    }
}
