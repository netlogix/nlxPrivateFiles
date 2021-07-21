<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxPrivateFiles\Models;

use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;

/**
 * @ORM\Entity()
 *
 * @ORM\Table(name="nlx_private_file")
 */
class PrivateFile extends ModelEntity
{
    const CONTROLLER_PATH_PREFIX = 'privateFiles/download/';
    const REAL_FILE_PATH_PREFIX = 'files/nlxPrivateFiles/';

    /**
     * @var string|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="id", type="string", nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", nullable=false)
     */
    private $extension = '';

    /**
     * @var string
     *
     * @ORM\Column(name="controller_path", type="string", nullable=false)
     */
    private $controllerPath = '';

    /**
     * @var string
     *
     * @ORM\Column(name="real_path", type="string", nullable=false)
     */
    private $realPath = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    public function __construct(
        string $id,
        string $name,
        string $extension,
        string $controllerPath,
        string $realPath
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->extension = $extension;
        $this->controllerPath = $controllerPath;
        $this->realPath = $realPath;
        $this->created = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getControllerPath(): string
    {
        return $this->controllerPath;
    }

    public function getRealPath(): string
    {
        return $this->realPath;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }
}
