<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxPrivateFiles\Factory;

use nlxPrivateFiles\Models\PrivateFile;

class PrivateFileFactory
{
    public function create(string $originalFilename, string $originalExtension, string $originalFullName): PrivateFile
    {
        $uniqId = \uniqid();

        return new PrivateFile(
            $uniqId,
            $originalFilename,
            $originalExtension,
            PrivateFile::CONTROLLER_PATH_PREFIX . $uniqId,
            PrivateFile::REAL_FILE_PATH_PREFIX . $originalFullName
        );
    }
}
