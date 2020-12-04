<?php

namespace EasyHttp\LayerContracts;

use EasyHttp\LayerContracts\Contracts\EasyClientContract;
use EasyHttp\LayerContracts\Contracts\HttpClientAdapter;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use EasyHttp\LayerContracts\Contracts\HttpClientResponse;

abstract class AbstractClient implements EasyClientContract
{
    protected HttpClientAdapter $adapter;

    protected HttpClientRequest $request;

    protected $handler;

    public function getRequest(): HttpClientRequest
    {
        return $this->request;
    }

    public function call(string $method, string $uri): HttpClientResponse
    {
        $request = $this->buildRequest($method, $uri);
        return $this->getAdapter()->request($request);
    }

    public function prepareRequest(string $method, string $uri): self
    {
        $this->request = $this->buildRequest($method, $uri);

        return $this;
    }

    public function withHandler(callable $handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    public function execute(): HttpClientResponse
    {
        return $this->getAdapter()->request($this->request);
    }

    abstract protected function buildRequest(string $method, string $uri): HttpClientRequest;
    abstract protected function getAdapter(): HttpClientAdapter;
}
