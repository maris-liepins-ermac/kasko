<?php

namespace App\IpInfo\Infrastructure\HttpClient;

use GuzzleHttp\Client;

final class HttpClientFactory
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getClient(): HttpClient
    {
        $client = new Client(
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                ],
                'allow_redirects' => ['strict' => true],
            ]
        );

        return new HttpClient($client, $this->baseUrl);
    }
}
