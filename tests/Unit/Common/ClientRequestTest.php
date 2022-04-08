<?php

namespace EasyHttp\LayerContracts\Tests\Unit\Common;

use EasyHttp\LayerContracts\Common\ClientRequestSecurity;
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
        $this->assertFalse($request->hasHeaders());
        $this->assertFalse($request->hasJson());
        $this->assertFalse($request->hasQuery());
        $this->assertFalse($request->hasSecurityContext());
        $this->assertFalse($request->isSSL());
        $this->assertFalse($request->hasBasicAuth());
    }

    /**
     * @test
     */
    public function itCanChangeItsData()
    {
        $request = new ClientRequest('POST', $this->faker->url);

        $method = 'GET';
        $url = $this->faker->url;
        $request->setMethod($method);
        $request->setUri($url);
        $request->setJson(['foo' => 'bar']);
        $request->setQuery(['bar' => 'baz']);
        $request->setTimeout(20);
        $request->setHeaders(['a' => 'b']);
        $request->setHeader('auth', 'xdsG56');
        $request->setBasicAuth('user', 'pass');
        $security = new ClientRequestSecurity();
        $request->setSecurityContext($security);

        $this->assertSame($method, $request->getMethod());
        $this->assertSame($url, $request->getUri());
        $this->assertSame(['foo' => 'bar'], $request->getJson());
        $this->assertTrue($request->hasJson());
        $this->assertSame(['bar' => 'baz'], $request->getQuery());
        $this->assertTrue($request->hasQuery());
        $this->assertSame(20, $request->getTimeout());
        $this->assertSame('xdsG56', $request->getHeader('auth'));
        $this->assertSame(['a' => 'b', 'auth' => 'xdsG56'], $request->getHeaders());
        $this->assertTrue($request->hasHeaders());
        $this->assertSame(['user', 'pass'], $request->getBasicAuth());
        $this->assertTrue($request->hasBasicAuth());
        $this->assertTrue($request->hasSecurityContext());
    }
}
