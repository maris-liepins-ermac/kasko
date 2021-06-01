<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Dto;

final class FileDto
{
    private ?string $filePath;
    private ?string $fileName;

    public function __construct(string $fileName, ?string $filePath = null)
    {
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    public function filePath(): ?string
    {
        return $this->filePath;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }
}
