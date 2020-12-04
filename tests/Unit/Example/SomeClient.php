<?php

namespace EasyHttp\LayerContracts\Tests\Unit\Example;

use EasyHttp\LayerContracts\AbstractClient;
use EasyHttp\LayerContracts\Contracts\HttpClientAdapter;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;

class SomeClient extends AbstractClient
{
    protected function buildRequest(string $method, string $uri): HttpClientRequest
    {
        $request = new ClientRequest();
        $request->setMethod($method)->setUri($uri);

        return $request;
    }

    protected function getAdapter(): HttpClientAdapter
    {
        return new ClientAdapter();
    }
}
