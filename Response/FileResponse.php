<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxPrivateFiles\Response;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileResponse extends \Enlight_Controller_Response_ResponseHttp
{
    public function sendFile(string $filePath, string $fileName = ''): void
    {
        $file = new \SplFileInfo($filePath);

        if (false === $file->isFile()) {
            throw new FileNotFoundException('File not found at path:' . $filePath);
        }

        \header('Content-Type: application/' . $file->getExtension());

        $name = '' === $fileName ? $file->getFilename() : $fileName;
        \header('Content-Disposition: attachment; filename=' . $name);
        $out = \fopen('php://output', 'wb');
        $file = \fopen($filePath, 'rb');

        \stream_copy_to_stream($file, $out, -1, 0);

        \fclose($out);
        \fclose($file);
    }
}
