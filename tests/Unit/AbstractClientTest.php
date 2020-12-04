<?php

namespace EasyHttp\LayerContracts\Tests\Unit;

use EasyHttp\LayerContracts\Tests\Unit\Example\SomeClient;
use PHPUnit\Framework\TestCase;

class AbstractClientTest extends TestCase
{
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
}
