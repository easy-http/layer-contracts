<?php

namespace EasyHttp\LayerContracts\Tests\Unit;

use EasyHttp\LayerContracts\Tests\Unit\Example\SomeClient;
use PHPUnit\Framework\TestCase;

class AbstractClientTest extends TestCase
{
    /**
     * @test
     */
    public function itExecutesARequest()
    {
        $client = new SomeClient();

        $response = $client->call('GET', 'http://example.com/api');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(['key' => 'value'], $response->toJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Debian)'], $response->getHeaders());
    }

    /**
     * @test
     */
    public function itPreparesARequestForExecution()
    {
        $client = new SomeClient();
        $client->prepareRequest('GET', 'http://example.com/api');

        $this->assertSame('GET', $client->getRequest()->getMethod());
        $this->assertSame('http://example.com/api', $client->getRequest()->getUri());
    }

    /**
     * @test
     */
    public function itExecutesAPreparedRequest()
    {
        $client = new SomeClient();
        $client->prepareRequest('GET', 'http://example.com/api');

        $response = $client->execute();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(['key' => 'value'], $response->toJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Debian)'], $response->getHeaders());
    }

    /**
     * @test
     */
    public function itReuseTheAdapterForEachRequest()
    {
        $client = new SomeClient();

        $client->call('GET', 'http://example.com/api');
        $client->call('GET', 'http://example.com/api');
        $client->call('GET', 'http://example.com/api');

        $this->assertSame(1, $client->getAdapterCounter());
    }

    /**
     * @test
     */
    public function itSetsHandlers()
    {
        $client = new SomeClient();

        $client->withHandler(
            function () {
                return [
                    'status' => 500,
                    'headers' => ['Server' => 'Apache/2.4.38 (Ubuntu)'],
                    'body' => '{"message":"Server Error"}',
                ];
            }
        );

        $response = $client->call('GET', 'some uri');

        $this->assertSame(500, $response->getStatusCode());
        $this->assertSame(['message' => 'Server Error'], $response->toJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Ubuntu)'], $response->getHeaders());
    }

    /**
     * @test
     */
    public function itFlushTheAdapterAfterSetsHandler()
    {
        $client = new SomeClient();

        $liveResponse = $client->call('GET', 'http://example.com/api');

        $client->withHandler(
            function () {
                return [
                    'status' => 500,
                    'headers' => ['Server' => 'Apache/2.4 (Ubuntu)'],
                    'body' => 'Server Error',
                ];
            }
        );

        $mockedResponse = $client->call('GET', 'some uri');

        $this->assertSame(200, $liveResponse->getStatusCode());
        $this->assertSame(['key' => 'value'], $liveResponse->toJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Debian)'], $liveResponse->getHeaders());
        $this->assertSame(500, $mockedResponse->getStatusCode());
        $this->assertSame(['Server' => 'Apache/2.4 (Ubuntu)'], $mockedResponse->getHeaders());
    }
}
