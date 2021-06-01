<?php

namespace App\IpInfo\Infrastructure\HttpClient;

final class ApiResponse
{
    private bool $success;
    private string $method;
    private string $uri;
    private array $payload;
    private string $response;
    private int $statusCode;

    private function __construct(bool $success, string $method, string $uri, array $payload, string $response, int $statusCode)
    {
        $this->success = $success;
        $this->method = $method;
        $this->uri = $uri;
        $this->payload = $payload;
        $this->response = $response;
        $this->statusCode = $statusCode;
    }

    public static function successful(
        string $method,
        string $uri,
        array $payload,
        string $response,
        int $statusCode
    ): ApiResponse {
        return new self(true, $method, $uri, $payload, $response, $statusCode);
    }

    public static function failure(
        string $method,
        string $uri,
        array $payload,
        string $response,
        int $statusCode
    ): ApiResponse {
        return new self(false, $method, $uri, $payload, $response, $statusCode);
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function response(): string
    {
        return $this->response;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}
