<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem;

use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\FileDto;
use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\StoreInputInterface;
use App\IpInfo\Infrastructure\Storage\Filesystem\Service\ValidateFilePathService;
use App\IpInfo\Infrastructure\Storage\Filesystem\Service\WriteToFileService;
use App\IpInfo\Infrastructure\Storage\StorageInterface;

final class Storage implements StorageInterface
{
    private string $storageBasePath;
    private ValidateFilePathService $filePathValidator;
    private WriteToFileService $writeToFileService;

    public function __construct(
        string $storageBasePath,
        ValidateFilePathService $filePathValidator,
        WriteToFileService $writeToFileService
    ) {
        $this->storageBasePath = $storageBasePath;
        $this->filePathValidator = $filePathValidator;
        $this->writeToFileService = $writeToFileService;
    }

    public function store(StoreInputInterface $storeInput): void
    {
        $fileDto = new FileDto(
            $storeInput->file()->fileName(),
            sprintf('%s/%s', $this->storageBasePath, $storeInput->file()->filePath())
        );
        $this->filePathValidator->validate($fileDto);
        $this->writeToFileService->write($fileDto, $storeInput->content());
    }
}
