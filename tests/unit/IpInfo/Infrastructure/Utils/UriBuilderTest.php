<?php

namespace App\Tests\unit\IpInfo\Infrastructure\Utils;

use App\IpInfo\Infrastructure\Utils\UriBuilder;
use PHPUnit\Framework\TestCase;

final class UriBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_tests_empty_uri()
    {
        $uriBuilder = new UriBuilder();
        $this->assertSame(null, $uriBuilder->uri());
    }

    /**
     * @test
     */
    public function it_tests_multiple_paths()
    {
        $uriBuilder = new UriBuilder();
        $path1 = 'first-path';
        $path2 = 'second-path';

        $uriBuilder->addPath($path1)->addPath($path2);
        $this->assertSame(sprintf('/%s/%s', $path1, $path2), $uriBuilder->uri());
    }

}