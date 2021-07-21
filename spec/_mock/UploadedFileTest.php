<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace spec\nlxPrivateFiles\_mock;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileTest extends UploadedFile
{
    private $path;

    private $originalName;

    private $extension;

    public function __construct(string $path, string $originalName, string $extension)
    {
        $this->path = $path;
        $this->originalName = $originalName;
        $this->extension = $extension;
    }

    public function getClientOriginalName(): string
    {
        return $this->originalName;
    }

    public function guessClientExtension(): string
    {
        return $this->extension;
    }

    public function move($directory, $name = null)
    {
    }
}
