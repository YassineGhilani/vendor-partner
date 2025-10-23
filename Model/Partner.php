<?php

declare(strict_types=1);

namespace Vendor\Partners\Model;

use Magento\Framework\Model\AbstractModel;
use Vendor\Partners\Model\ResourceModel\Partner as ResourceModel;
use Vendor\Partners\Api\Data\PartnerInterface;

/**
 * Partner model with convenience methods.
 */
class Partner extends AbstractModel implements PartnerInterface
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    public function getId(): ?int
    {
        $id = $this->getData(self::PARTNER_ID);
        return $id !== null ? (int)$id : null;
    }

    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    public function getLogo(): ?string
    {
        return $this->getData(self::LOGO);
    }

    public function getUrl(): ?string
    {
        return $this->getData(self::URL);
    }

    public function getStartDate(): ?string
    {
        return $this->getData(self::START_DATE);
    }

    public function getIsActive(): ?int
    {
        $val = $this->getData(self::IS_ACTIVE);
        return $val !== null ? (int)$val : null;
    }

    public function setId(int $id): self
    {
        $this->setData(self::PARTNER_ID, $id);
        return $this;
    }

    public function setName(string $name): self
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    public function setLogo(?string $logo): self
    {
        $this->setData(self::LOGO, $logo);
        return $this;
    }

    public function setUrl(?string $url): self
    {
        $this->setData(self::URL, $url);
        return $this;
    }

    public function setStartDate(?string $date): self
    {
        $this->setData(self::START_DATE, $date);
        return $this;
    }

    public function setIsActive(int $isActive): self
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }

    /**
     * Returns absolute URL to logo file (or empty string).
     *
     * Uses store manager base media URL.
     */
    public function getLogoUrl(): string
    {
        $logo = $this->getLogo();
        if (!$logo) {
            return '';
        }

        $base = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        // Ensure no double slashes
        return rtrim($base, '/') . '/' . ltrim($logo, '/');
    }

    /*
    * Validating Partner Object before saving
    */
    public function validateBeforeSave(array $data): void
    {
        if (empty($data['name'])) {
            throw new \InvalidArgumentException('Le nom du partenaire est obligatoire.');
        }
        if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('URL invalide.');
        }
        if (!empty($data['is_active']) && empty($data['logo'])) {
            throw new \InvalidArgumentException('Un partenaire actif doit avoir un logo.');
        }
    }
}
