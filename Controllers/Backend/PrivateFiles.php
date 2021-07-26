<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

use nlxPrivateFiles\Models\PrivateFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Shopware_Controllers_Backend_PrivateFiles extends Shopware_Controllers_Backend_Application
{
    /** @var string */
    protected $model = PrivateFile::class;

    /** @var string */
    protected $alias = 'privateFile';

    public function uploadAction(): void
    {
        if (false === $this->Request()->files->has('fileId')) {
            $this->View()->assign(['success' => false]);

            return;
        }
        /** @var UploadedFile $file */
        $file = $this->Request()->files->get('fileId');

        if (false === $file instanceof UploadedFile) {
            $this->View()->assign(['success' => false]);

            return;
        }
        $this->uploadFile($file);

        $this->View()->assign(['success' => true]);
    }

    public function deleteAction(): void
    {
        $privateFileId = $this->Request()->getParam('id');
        $privateFile = $this->getManager()->find($this->model, $privateFileId);
        $realPath = $privateFile->getRealPath();

        \unlink($realPath);

        parent::deleteAction();
    }

    private function uploadFile(UploadedFile $file): void
    {
        try {
            $uploadHelper = Shopware()->Container()->get('nlx.private_files.services.upload_helper');

            $uploadHelper->upload($file);
        } catch (\Throwable $exception) {
            $this->View()->assign(['success' => false, 'message' => $exception->getMessage()]);

            return;
        }
    }
}
