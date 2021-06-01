<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Service;

use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\FileDto;
use App\IpInfo\Infrastructure\Storage\Filesystem\Exception\FileAlreadyExists;
use App\IpInfo\Infrastructure\Storage\Filesystem\Exception\InvalidDirectoryRequested;
use App\IpInfo\Infrastructure\Storage\Filesystem\Exception\InvalidFileExtension;
use Symfony\Component\Filesystem\Filesystem;

final class ValidateFilePathService
{
    private const FILE_EXTENSION = 'json';
    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function validate(FileDto $fileDto): void
    {
        $this->validExtension($fileDto->fileName());
        $this->dirExists($fileDto->filePath());
        $this->fileDoesNotExist(sprintf('%s/%s', $fileDto->filePath(), $fileDto->fileName()));
    }

    private function dirExists(string $pathToDir): void
    {
        if (!$this->filesystem->exists($pathToDir)) {
            throw InvalidDirectoryRequested::dueToInvalidPath();
        }
    }

    private function fileDoesNotExist(string $fullPath): void
    {
        if ($this->filesystem->exists($fullPath)) {
            throw FileAlreadyExists::dueToExistingFile();
        }
    }

    private function validExtension(string $filename): void
    {
        if (self::FILE_EXTENSION !== pathinfo($filename, PATHINFO_EXTENSION)) {
            throw InvalidFileExtension::dueToInvalidExtension(sprintf('Supported file extensions: %s', self::FILE_EXTENSION));
        }
    }
}
