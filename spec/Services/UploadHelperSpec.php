<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace spec\nlxPrivateFiles\Services;

use Doctrine\ORM\EntityManagerInterface;
use nlxPrivateFiles\Exceptions\FileExistException;
use nlxPrivateFiles\Factory\PrivateFileFactory;
use nlxPrivateFiles\Models\PrivateFile;
use nlxPrivateFiles\Services\UploadHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Shopware\Components\Model\ModelRepository;
use spec\nlxPrivateFiles\_mock\UploadedFileTest;

class UploadHelperSpec extends ObjectBehavior
{
    public function let(
        EntityManagerInterface $entityManager,
        PrivateFileFactory $privateFileFactory,
        ModelRepository $privateFileRepository
    ): void {
        $entityManager->getRepository(PrivateFile::class)
            ->willReturn($privateFileRepository);

        $this->beConstructedWith($entityManager, $privateFileFactory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UploadHelper::class);
    }

    public function it_should_upload_file(
        EntityManagerInterface $entityManager,
        PrivateFileFactory $privateFileFactory,
        ModelRepository $privateFileRepository,
        PrivateFile $privateFile
    ): void {
        $originalFilename = 'testName';
        $originalExtension = 'txt';
        $originalFullName = $originalFilename . '.' . $originalExtension;

        $uploadedFile = new UploadedFileTest('testpath', $originalFilename, $originalExtension);

        $privateFileRepository->findBy(['name' => $originalFilename, 'extension' => $originalExtension])
            ->willReturn([]);

        $privateFileFactory->create($originalFilename, $originalExtension, $originalFullName)
            ->willReturn($privateFile);

        $entityManager->persist($privateFile)
            ->shouldBeCalled();
        $entityManager->flush()
            ->shouldBeCalled();

        $this->upload($uploadedFile);
    }

    public function it_should_throw_exception_if_file_exists(
        EntityManagerInterface $entityManager,
        PrivateFileFactory $privateFileFactory,
        ModelRepository $privateFileRepository,
        PrivateFile $privateFile
    ): void {
        $originalFilename = 'testName';
        $originalExtension = 'txt';

        $uploadedFile = new UploadedFileTest('testpath', $originalFilename, $originalExtension);

        $privateFileRepository->findBy(['name' => $originalFilename, 'extension' => $originalExtension])
            ->willReturn([$privateFile]);

        $privateFileFactory->create(Argument::any(), Argument::any(), Argument::any())
            ->shouldNotBeCalled();

        $entityManager->persist(Argument::any())
            ->shouldNotBeCalled();
        $entityManager->flush()
            ->shouldNotBeCalled();

        $this->shouldThrow(FileExistException::class)
            ->during('upload', [$uploadedFile]);
    }
}
