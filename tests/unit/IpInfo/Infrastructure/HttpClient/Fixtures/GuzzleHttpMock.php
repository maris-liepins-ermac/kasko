<?php

namespace App\Tests\unit\IpInfo\Infrastructure\HttpClient\Fixtures;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GuzzleHttpMock implements ClientInterface
{
    private array $container = [];
    private Client $client;
    private MockHandler $handler;

    public function __construct()
    {
        $this->handler = new MockHandler();
        $history = Middleware::history($this->container);
        $handlerStack = HandlerStack::create($this->handler);
        $handlerStack->push($history);
        $this->client = new Client(['handler' => $handlerStack]);
    }

    public function request($method, $uri, array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }

    public function appendResponse(Response $response): void
    {
        $this->handler->append($response);
    }
    public function container():array
    {
        return $this->container;
    }

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->client->send($request, $options);
    }

    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->client->sendAsync($request, $options);
    }

    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        return $this->client->requestAsync($method, $uri, $options);
    }

    public function getConfig(?string $option = null)
    {
        return $this->client->getConfig();
    }
}