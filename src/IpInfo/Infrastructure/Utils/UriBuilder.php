<?php

namespace App\IpInfo\Infrastructure\Utils;

final class UriBuilder
{
    private const PATH_SEPARATOR = '/';
    private ?string $uri;

    public function __construct(?string $baseUri = null)
    {
        $this->uri = $baseUri;
    }

    public function addPath(string $path): self
    {
        $this->uri = sprintf('%s%s%s', $this->uri, self::PATH_SEPARATOR, $path);

        return $this;
    }

    public function uri(): ?string
    {
        return $this->uri;
    }
}
