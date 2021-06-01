<?php

namespace App\IpInfo\Infrastructure\HttpClient;

use App\IpInfo\Infrastructure\HttpClient\Dto\RequestParamsDto;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

final class HttpClient
{
    private ClientInterface $client;
    private string $baseUrl;

    public function __construct(ClientInterface $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    public function send(RequestParamsDto $requestParams): ApiResponse
    {
        $uri = $this->getUri($requestParams->url());

        try {
            $response = $this->client->request(
                $requestParams->method(),
                $uri,
                $requestParams->payload()
            );

            return ApiResponse::successful(
                $requestParams->method(),
                $uri,
                $requestParams->payload(),
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );
        } catch (RequestException $exception) {
            return ApiResponse::failure(
                $requestParams->method(),
                $uri,
                $requestParams->payload(),
                $exception->getResponse()->getBody()->getContents(),
                $exception->getResponse()->getStatusCode()
            );
        }
    }

    private function getUri(string $url): string
    {
        return sprintf(
            '%s/%s',
            trim($this->baseUrl, '/'),
            trim($url, '/')
        );
    }
}
