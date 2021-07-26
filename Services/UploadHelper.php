<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxPrivateFiles\Services;

use \Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use nlxPrivateFiles\Exceptions\FileExistException;
use nlxPrivateFiles\Factory\PrivateFileFactory;
use nlxPrivateFiles\Models\PrivateFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PrivateFileFactory */
    private $privateFileFactory;

    /** @var ObjectRepository */
    private $privateFileRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        PrivateFileFactory $privateFileFactory
    ) {
        $this->entityManager = $entityManager;
        $this->privateFileFactory = $privateFileFactory;

        $this->privateFileRepository = $entityManager->getRepository(PrivateFile::class);
    }

    public function upload(UploadedFile $uploadedFile): void
    {
        $originalFilename = \pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = null !== $uploadedFile->guessClientExtension() ? $uploadedFile->guessClientExtension() : '';
        $originalFullName = $originalFilename . '.' . $originalExtension;

        $privateFiles = $this->privateFileRepository->findBy(['name' => $originalFilename, 'extension' => $originalExtension]);

        if (false === empty($privateFiles)) {
            throw new FileExistException(\sprintf(
                'File with the name %s already exists',
                $originalFullName
            ));
        }
        $privateFile = $this->privateFileFactory->create($originalFilename, $originalExtension, $originalFullName);

        $uploadedFile->move(PrivateFile::REAL_FILE_PATH_PREFIX, $originalFullName);

        $this->entityManager->persist($privateFile);
        $this->entityManager->flush();
    }
}
