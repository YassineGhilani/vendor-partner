<?php
declare(strict_types=1);

namespace Vendor\Partners\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Vendor\Partners\Model\ResourceModel\Partner\CollectionFactory;

/**
 * DataProvider for UI components: prepares data for grid & form.
 * Formats 'logo' to the structure expected by imageUploader in form.
 */
class PartnerDataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Return data indexed by id: [id => dataArray]
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $data = $item->getData();
            // Format logo for imageUploader (if exists)
            if (!empty($data['logo'])) {
                $data['logo'] = [
                    [
                        'name' => basename($data['logo']),
                        'url' => $item->getLogoUrl()
                    ]
                ];
            }
            $this->loadedData[$item->getId()] = $data;
        }

        return $this->loadedData;
    }
}
