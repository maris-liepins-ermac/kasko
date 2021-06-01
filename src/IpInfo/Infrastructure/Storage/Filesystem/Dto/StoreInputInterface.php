<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Dto;

interface StoreInputInterface
{
    public function content(): string;

    public function file(): FileDto;
}
