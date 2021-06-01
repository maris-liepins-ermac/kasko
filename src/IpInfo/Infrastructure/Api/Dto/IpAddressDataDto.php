<?php

namespace App\IpInfo\Infrastructure\Api\Dto;

final class IpAddressDataDto
{
    private ?string $ip;
    private ?string $authToken;
    private ?string $filter;

    public function __construct(?string $ip = null, ?string $authToken = null, ?string $filter = null)
    {
        $this->ip = $ip;
        $this->authToken = $authToken;
        $this->filter = $filter;
    }

    public function ip(): ?string
    {
        return $this->ip;
    }

    public function filter(): ?string
    {
        return $this->filter;
    }

    public function toPayload(): array
    {
        return [
            'token' => $this->authToken,
        ];
    }
}
