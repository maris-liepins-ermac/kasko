<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Dto;

final class StoreInputDto implements StoreInputInterface
{
    private string $content;
    private FileDto $file;

    public function __construct(string $content, FileDto $filePath)
    {
        $this->content = $content;
        $this->file = $filePath;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function file(): FileDto
    {
        return $this->file;
    }
}
