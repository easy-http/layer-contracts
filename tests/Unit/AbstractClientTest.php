<?php

namespace EasyHttp\LayerContracts\Tests\Unit;

use EasyHttp\LayerContracts\Contracts\HttpClientResponse;
use EasyHttp\LayerContracts\Exceptions\HttpClientException;
use EasyHttp\LayerContracts\Exceptions\ImpossibleToParseJsonException;
use EasyHttp\LayerContracts\Tests\Unit\Example\SomeClient;
use PHPUnit\Framework\TestCase;

class AbstractClientTest extends TestCase
{
    protected string $uri = 'http://example.com/api';

    /**
     * @test
     */
    public function itExecutesARequest(): HttpClientResponse
    {
        $client = new SomeClient();

        $response = $client->call('GET', $this->uri);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('{"key":"value"}', $response->getBody());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Debian)'], $response->getHeaders());

        return $response;
    }

    /**
     * @test
     * @depends itExecutesARequest
     * @param HttpClientResponse $response
     * @throws ImpossibleToParseJsonException
     */
    public function itCanParseAResponseToJson(HttpClientResponse $response)
    {
        $this->assertSame(['key' => 'value'], $response->parseJson());
    }

    /**
     * @test
     */
    public function itPreparesARequestForExecution()
    {
        $client = new SomeClient();
        $client->prepareRequest('GET', $this->uri);

        $this->assertSame('GET', $client->getRequest()->getMethod());
        $this->assertSame('http://example.com/api', $client->getRequest()->getUri());
    }

    /**
     * @test
     */
    public function itExecutesAPreparedRequest()
    {
        $client = new SomeClient();
        $client->prepareRequest('GET', $this->uri);

        $response = $client->execute();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(['key' => 'value'], $response->parseJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Debian)'], $response->getHeaders());
    }

    /**
     * @test
     */
    public function itReuseTheAdapterForEachRequest()
    {
        $client = new SomeClient();

        $client->call('GET', $this->uri);
        $client->call('GET', $this->uri);
        $client->call('GET', $this->uri);

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

        $response = $client->call('GET', $this->uri);

        $this->assertSame(500, $response->getStatusCode());
        $this->assertSame(['message' => 'Server Error'], $response->parseJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Ubuntu)'], $response->getHeaders());
    }

    /**
     * @test
     */
    public function itFlushTheAdapterAfterSetsHandler()
    {
        $client = new SomeClient();

        $liveResponse = $client->call('GET', $this->uri);

        $client->withHandler(
            function () {
                return [
                    'status' => 500,
                    'headers' => ['Server' => 'Apache/2.4 (Ubuntu)'],
                    'body' => 'Server Error - Try later again',
                ];
            }
        );

        $mockedResponse = $client->call('GET', $this->uri);

        $this->assertSame(200, $liveResponse->getStatusCode());
        $this->assertSame(['key' => 'value'], $liveResponse->parseJson());
        $this->assertSame(['Server' => 'Apache/2.4.38 (Debian)'], $liveResponse->getHeaders());
        $this->assertSame(500, $mockedResponse->getStatusCode());
        $this->assertSame(['Server' => 'Apache/2.4 (Ubuntu)'], $mockedResponse->getHeaders());
    }

    /**
     * This test is just a mock!. The responsibility for throwing this exception lies
     * with the library who is implementing this contracts!
     *
     * @test
     */
    public function itThrowsClientExceptionWhenFails()
    {
        $this->expectException(HttpClientException::class);

        $client = new SomeClient();

        $client->withHandler(
            function () {
                throw new HttpClientException('Bad request exception');
            }
        );

        $client->call('GET', $this->uri);
    }

    public function itThrowsNotParsedExceptionWhenInvalidJsonIsFound()
    {
        $this->expectException(ImpossibleToParseJsonException::class);

        $client = new SomeClient();

        $client->withHandler(
            function () {
                return 'HTTP 500 - Server Error';
            }
        );

        $response = $client->call('GET', $this->uri);
        $response->parseJson();
    }
}
