<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxPrivateFiles\Exceptions;

class FileNotExistException extends \RuntimeException
{
    public function __construct(string $fileId)
    {
        parent::__construct(\sprintf('The file with the ID "%s" does not exist', $fileId));
    }
}
