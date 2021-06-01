<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Service;

use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\FileDto;
use Symfony\Component\Filesystem\Filesystem;

final class WriteToFileService
{
    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function write(FileDto $fileDto, string $contents): void
    {
        $fullPath = sprintf('%s/%s', $fileDto->filePath(), $fileDto->fileName());
        $this->filesystem->dumpFile($fullPath, $contents);
    }
}
