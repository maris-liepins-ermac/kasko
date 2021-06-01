<?php

namespace App\Tests\unit\IpInfo\Infrastructure\Api;

use App\IpInfo\Infrastructure\Api\ApiClient;
use App\IpInfo\Infrastructure\Api\Dto\IpAddressDataDto;
use App\IpInfo\Infrastructure\HttpClient\HttpClient;
use App\IpInfo\Infrastructure\Utils\UriBuilder;
use App\Tests\unit\IpInfo\Infrastructure\HttpClient\Fixtures\GuzzleHttpMock;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class IpAddressDataEndpointTest extends TestCase
{
    private GuzzleHttpMock $httpMock;
    private ApiClient $it;

    public function setUp(): void
    {
        $this->httpMock = new GuzzleHttpMock();
        $httpClient = new HttpClient($this->httpMock, getenv('IP_INFO_BASE_URL'));
        $this->it = new ApiClient($httpClient);
    }

    /**
     * @test
     */
    public function it_tests_valid_request_with_valid_url(): void
    {
        $this->httpMock->appendResponse(new Response(200, ['X-Foo' => 'Bar'], 'Successful call'));
        $ip = '127.0.0.1';
        $payload = new IpAddressDataDto($ip);

        $uriBuilder = new UriBuilder();
        $uriBuilder->addPath($ip);

        $this->it->ipAddressData($payload);

        $request = $this->httpMock->container()[0]['request'];
        $this->assertSame('GET', $request->getMethod());

        $this->assertSame(
            $uriBuilder->uri(),
            $request->getUri()->getPath()
        );
    }

    /**
     * @test
     */
    public function it_tests_request_without_parameters_passed_to_it(): void
    {
        $this->httpMock->appendResponse(new Response(200, ['X-Foo' => 'Bar'], 'Successful call'));
        $payload = new IpAddressDataDto();

        $this->it->ipAddressData($payload);

        $request = $this->httpMock->container()[0]['request'];
        $this->assertSame('GET', $request->getMethod());

        $this->assertSame(
            '/',
            $request->getUri()->getPath()
        );
    }

    /**
     * @test
     */
    public function it_tests_filter_parameter_with_ip(): void
    {
        $this->httpMock->appendResponse(new Response(200, ['X-Foo' => 'Bar'], 'Successful call'));

        $ip = '127.0.0.1';
        $filter = 'city';

        $payload = new IpAddressDataDto($ip, null, $filter);

        $uriBuilder = new UriBuilder();
        $uriBuilder->addPath($ip);
        $uriBuilder->addPath($filter);

        $this->it->ipAddressData($payload);

        $request = $this->httpMock->container()[0]['request'];
        $this->assertSame('GET', $request->getMethod());

        $this->assertSame(
            $uriBuilder->uri(),
            $request->getUri()->getPath()
        );
    }

    /**
     * @test
     */
    public function it_tests_request_with_token_and_ip(): void
    {
        $this->httpMock->appendResponse(new Response(200, ['X-Foo' => 'Bar'], 'Successful call'));

        $ip = '127.0.0.1';
        $token = 'i am a token';
        $formattedToken = http_build_query(['token' => $token]);

        $payload = new IpAddressDataDto($ip, $token);

        $uriBuilder = new UriBuilder();
        $uriBuilder->addPath($ip);

        $this->it->ipAddressData($payload);

        $request = $this->httpMock->container()[0]['request'];
        $this->assertSame('GET', $request->getMethod());

        $this->assertSame(
            sprintf('%s/%s', $uriBuilder->uri(), $formattedToken),
            $request->getUri()->getPath()
        );
    }

    /**
     * @test
     */
    public function it_tests_request_with_token_and_ip_and_filter(): void
    {
        $this->httpMock->appendResponse(new Response(200, ['X-Foo' => 'Bar'], 'Successful call'));

        $ip = '127.0.0.1';
        $filter = 'city';
        $token = 'i am a token';
        $formattedToken = http_build_query(['token' => $token]);

        $payload = new IpAddressDataDto($ip, $token, $filter);

        $uriBuilder = new UriBuilder();
        $uriBuilder->addPath($ip);
        $uriBuilder->addPath($filter);

        $this->it->ipAddressData($payload);

        $request = $this->httpMock->container()[0]['request'];
        $this->assertSame('GET', $request->getMethod());

        $this->assertSame(
            sprintf('%s/%s', $uriBuilder->uri(), $formattedToken),
            $request->getUri()->getPath()
        );
    }
}