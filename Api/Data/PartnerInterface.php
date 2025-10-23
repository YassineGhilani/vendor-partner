<?php
declare(strict_types=1);

namespace Vendor\Partners\Api\Data;

/**
 * Data interface for Partner entity.
 * Define constants and getter/setter signatures used across module.
 */
interface PartnerInterface
{
    public const PARTNER_ID = 'partner_id';
    public const NAME = 'name';
    public const LOGO = 'logo';
    public const URL = 'url';
    public const START_DATE = 'start_date';
    public const IS_ACTIVE = 'is_active';

    public function getId(): ?int;
    public function getName(): ?string;
    public function getLogo(): ?string;
    public function getUrl(): ?string;
    public function getStartDate(): ?string;
    public function getIsActive(): ?int;

    public function setId(int $id): self;
    public function setName(string $name): self;
    public function setLogo(?string $logo): self;
    public function setUrl(?string $url): self;
    public function setStartDate(?string $date): self;
    public function setIsActive(int $isActive): self;
}
