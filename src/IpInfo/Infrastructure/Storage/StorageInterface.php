<?php

namespace App\IpInfo\Infrastructure\Storage;

use App\IpInfo\Infrastructure\Storage\Filesystem\Dto\StoreInputInterface;

interface StorageInterface
{
    public function store(StoreInputInterface $storeInput): void;
}
