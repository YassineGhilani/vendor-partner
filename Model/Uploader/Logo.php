<?php
declare(strict_types=1);

namespace Vendor\Partners\Model\Uploader;

use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;

/**
 * Upload service responsible for storing partner logos under pub/media/partners.
 * Keeps controller thin and centralizes upload logic.
 */
class Logo
{
    private Filesystem $filesystem;
    private UploaderFactory $uploaderFactory;

    public function __construct(
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory
    ) {
        $this->filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
    }

    /**
     * Save an uploaded file (identified by $fileId like 'logo') to media/partners.
     * Returns the relative path stored in DB (e.g. partners/abcd.png).
     *
     * @throws LocalizedException
     */
    public function saveUploadedFile(string $fileId = 'logo'): string
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'svg']);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $target = $mediaDirectory->getAbsolutePath('partners');

            $result = $uploader->save($target);
            if (!$result || !isset($result['file'])) {
                throw new LocalizedException(__('Unable to save file to %1', $target));
            }

            return 'partners/' . ltrim($result['file'], '/');
        } catch (LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new LocalizedException(__('File upload error: %1', $e->getMessage()));
        }
    }
}
