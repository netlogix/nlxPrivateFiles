<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright solutionDrive GmbH
 */

namespace nlxPrivateFiles\Bootstrap;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use nlxPrivateFiles\Models\PrivateFile;

class Database
{
    /** @var EntityManager */
    private $entityManager;

    /** @var SchemaTool */
    private $schemaTool;

    /** @var ObjectRepository $badgeRepository */
    private $badgeRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->badgeRepository = $this->entityManager->getRepository(PrivateFile::class);
        $this->schemaTool = new SchemaTool($this->entityManager);
    }

    /**
     * Installs all registered ORM classes
     */
    public function install()
    {
        $this->schemaTool->updateSchema(
            $this->getClassesMetaData(),
            true // make sure to use the save mode
        );
    }

    /**
     * Drops all registered ORM classes
     */
    public function uninstall()
    {
        $this->schemaTool->dropSchema(
            $this->getClassesMetaData()
        );
    }

    /**
     * @return ClassMetadata[]
     */
    private function getClassesMetaData(): array
    {
        return [
            $this->entityManager->getClassMetadata(PrivateFile::class),
        ];
    }
}
