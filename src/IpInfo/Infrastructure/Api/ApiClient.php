<?php

namespace App\IpInfo\Infrastructure\Api;

use App\IpInfo\Infrastructure\Api\Dto\IpAddressDataDto;
use App\IpInfo\Infrastructure\HttpClient\ApiResponse;
use App\IpInfo\Infrastructure\HttpClient\Dto\RequestParamsDto;
use App\IpInfo\Infrastructure\HttpClient\HttpClient;
use App\IpInfo\Infrastructure\Utils\UriBuilder;

final class ApiClient
{
    private HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function ipAddressData(IpAddressDataDto $ipDataDto): ApiResponse
    {
        $uriBuilder = new UriBuilder();

        if ($ipDataDto->ip()) {
            $uriBuilder->addPath($ipDataDto->ip());
        }

        if ($ipDataDto->filter()) {
            $uriBuilder->addPath($ipDataDto->filter());
        }

        $uriWithParams = sprintf(
            '%s/%s',
            $uriBuilder->uri(),
            http_build_query($ipDataDto->toPayload())
        );

        return $this->client->send(RequestParamsDto::get($uriWithParams));
    }
}
