<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

use nlxPrivateFiles\Exceptions\FileIdIsNotValidException;
use nlxPrivateFiles\Exceptions\FileNotExistException;
use nlxPrivateFiles\Exceptions\UserIsNotLoggedInException;
use nlxPrivateFiles\Models\PrivateFile;
use nlxPrivateFiles\Response\FileResponse;
use Psr\Log\LoggerInterface;

class Shopware_Controllers_Frontend_PrivateFiles extends Enlight_Controller_Action
{
    /** @var sAdmin */
    protected $admin;

    /** @var LoggerInterface */
    private $logger;

    public function init(): void
    {
        $this->admin = Shopware()->Modules()->Admin();
        $this->logger = Shopware()->Container()->get('pluginlogger');
    }

    public function downloadAction(): void
    {
        $this->Front()->Plugins()->ViewRenderer()->setNoRender();

        $response = new FileResponse();

        $this->download($response);
    }

    private function download(FileResponse $response): void
    {
        try {
            if (!$this->admin->sCheckUser()) {
                throw new UserIsNotLoggedInException('User is not correctly logged in');
            }
            $request = $this->Request();
            $fileId = (string) $request->getParam('fileId', '');

            if ('' === $fileId) {
                throw new FileIdIsNotValidException('File ID is not valid');
            }
            /** @var PrivateFile $privateFile */
            $privateFile = $this->getModelManager()->find(PrivateFile::class, $fileId);

            if (null === $privateFile) {
                throw new FileNotExistException($fileId);
            }
            $response->sendFile($privateFile->getRealPath());

            $this->setResponse($response);
        } catch (Throwable $exception) {
            $response->setHttpResponseCode(204);
            $this->redirect([
                'controller' => 'account',
                'action' => 'index',
            ]);
            $this->logger->error('[nlxPrivateFiles] Error during download', [
                'exception' => $exception,
            ]);
        }
    }
}
