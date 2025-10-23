<?php
declare(strict_types=1);

namespace Vendor\Partners\Controller\Adminhtml\Partner;

use Magento\Backend\App\Action;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Exception\LocalizedException;

/**
 * Endpoint used by UI file uploader (imageUploader) to upload to media/tmp.
 * The Save controller will move file to media/partners.
 */
class Upload extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Partners::partners';

    private UploaderFactory $uploaderFactory;
    private Filesystem $filesystem;

    public function __construct(
        Action\Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
    }

    public function execute()
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => 'logo']);
            $uploader->setAllowedExtensions(['jpg','jpeg','png','gif','svg']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $mediaDirectory = $this->filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $target = $mediaDirectory->getAbsolutePath('tmp');

            $result = $uploader->save($target);
            if (!$result) {
                throw new LocalizedException(__('File cannot be saved'));
            }

            // Provide the expected response for imageUploader
            $result['url'] = $this->_url->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . 'tmp/' . $result['file'];

            return $this->getResponse()->representJson(json_encode($result));
        } catch (LocalizedException $e) {
            return $this->getResponse()->representJson(json_encode(['error' => $e->getMessage()]));
        } catch (\Exception $e) {
            return $this->getResponse()->representJson(json_encode(['error' => $e->getMessage()]));
        }
    }
}
