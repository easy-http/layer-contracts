<?php

namespace EasyHttp\LayerContracts\Tests\Unit\Common;

use EasyHttp\LayerContracts\Tests\TestCase;
use EasyHttp\LayerContracts\Tests\Unit\Example\ClientRequest;

class ClientRequestTest extends TestCase
{
    /**
     * @test
     */
    public function itSetsInitialProperties()
    {
        $method = 'POST';
        $url = $this->faker->url;

        $request = new ClientRequest($method, $url);

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($url, $request->getUri());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $method = 'POST';
        $url = $this->faker->url;

        $request = new ClientRequest($method, $url);

        $method = 'GET';
        $url = $this->faker->url;
        $request->setMethod($method);
        $request->setUri($url);
        $request->setJson(['foo' => 'bar']);
        $request->setQuery(['bar' => 'baz']);
        $request->setTimeout(20);
        $request->setHeader('auth', 'xdsG56');
        $request->setBasicAuth('user', 'pass');

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($url, $request->getUri());
        $this->assertSame(['foo' => 'bar'], $request->getJson());
        $this->assertSame(['bar' => 'baz'], $request->getQuery());
        $this->assertSame(20, $request->getTimeout());
        $this->assertSame(['auth' => 'xdsG56'], $request->getHeaders());
        $this->assertSame('xdsG56', $request->getHeader('auth'));
        $this->assertSame(['user', 'pass'], $request->getBasicAuth());
    }
}
