<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Exception;

use RuntimeException;

final class FileAlreadyExists extends RuntimeException
{
    private const DEFAULT_MESSAGE = 'File already exists with such name in given directory.';

    public static function dueToExistingFile(?string $message = null): self
    {
        $errorMessage = null === $message ? self::DEFAULT_MESSAGE : $message;

        return new self($errorMessage);
    }
}
