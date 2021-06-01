<?php

namespace App\IpInfo\Infrastructure\HttpClient\Dto;

class RequestParamsDto
{
    private string $url;
    private string $method;
    private array $payload;

    private function __construct(string $url, string $method, array $payload = [])
    {
        $this->url = $url;
        $this->method = $method;
        $this->payload = $payload;
    }

    public static function get(string $url, array $payload = []): RequestParamsDto
    {
        return new self($url, 'GET', $payload);
    }

    public function url(): string
    {
        return $this->url;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function payload(): array
    {
        return $this->payload;
    }
}
