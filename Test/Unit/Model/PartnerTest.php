<?php
declare(strict_types=1);

namespace Vendor\Partners\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Vendor\Partners\Model\Partner;
use InvalidArgumentException;

class PartnerTest extends TestCase
{
    private Partner $partner;

    protected function setUp(): void
    {
        $this->partner = new Partner();
    }

    public function testValidPartnerData(): void
    {
        $this->partner->setData([
            'name' => 'Google',
            'url' => 'https://google.com',
            'logo' => 'google.png',
            'start_date' => '2025-01-01',
            'is_active' => 1,
        ]);

        $this->assertEquals('Google', $this->partner->getData('name'));
        $this->assertEquals('https://google.com', $this->partner->getData('url'));
        $this->assertEquals('google.png', $this->partner->getData('logo'));
        $this->assertEquals('2025-01-01', $this->partner->getData('start_date'));
        $this->assertEquals(1, $this->partner->getData('is_active'));
    }

    public function testThrowsExceptionIfUrlInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->partner->validateBeforeSave([
            'name' => 'Google',
            'url' => 'invalid-url',
            'logo' => 'logo.png',
        ]);
    }

    public function testThrowsExceptionIfMissingName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->partner->validateBeforeSave([
            'url' => 'https://example.com',
            'logo' => 'logo.png',
        ]);
    }

    public function testThrowsExceptionIfActiveWithoutLogo(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->partner->validateBeforeSave([
            'name' => 'Partner',
            'url' => 'https://example.com',
            'is_active' => 1,
        ]);
    }
}
