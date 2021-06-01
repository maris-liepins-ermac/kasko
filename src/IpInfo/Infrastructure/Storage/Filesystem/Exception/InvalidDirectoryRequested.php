<?php

namespace App\IpInfo\Infrastructure\Storage\Filesystem\Exception;

use RuntimeException;

final class InvalidDirectoryRequested extends RuntimeException
{
    private const DEFAULT_MESSAGE = 'Invalid directory requested.';

    public static function dueToInvalidPath(?string $message = null): self
    {
        $errorMessage = null === $message ? self::DEFAULT_MESSAGE : $message;

        return new self($errorMessage);
    }
}
