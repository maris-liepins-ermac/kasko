<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Exception;

use RuntimeException;

final class InvalidFileExtension extends RuntimeException
{
    private const DEFAULT_MESSAGE = 'Invalid file extension provided.';

    public static function dueToInvalidExtension(?string $message = null): self
    {
        $errorMessage = null === $message ? self::DEFAULT_MESSAGE : $message;

        return new self($errorMessage);
    }
}
