<?php

namespace EasyHttp\LayerContracts\Tests\Unit\Example;

use EasyHttp\LayerContracts\Contracts\HttpClientRequest;

class ClientRequest implements HttpClientRequest
{
    protected string $method;
    protected string $uri;
    protected array $json;
    protected array $query;
    protected array $headers;
    protected bool $ssl;
    protected array $options;

    public function getMethod(): string
    {
        return $this->method ?? '';
    }

    public function getUri(): string
    {
        return $this->uri ?? '';
    }

    public function getJson(): array
    {
        return $this->json ?? [];
    }

    public function getQuery(): array
    {
        return $this->query ?? [];
    }

    public function getHeader(string $key)
    {
        return $this->headers[$key] ?? '';
    }

    public function setMethod(string $method): HttpClientRequest
    {
        $this->method = $method;

        return $this;
    }

    public function setUri(string $uri): HttpClientRequest
    {
        $this->uri = $uri;

        return $this;
    }

    public function setHeader(string $key, string $value): HttpClientRequest
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function setJson(array $json): HttpClientRequest
    {
        $this->json = $json;

        return $this;
    }

    public function setQuery(array $query): HttpClientRequest
    {
        $this->query = $query;

        return $this;
    }

    public function ssl(bool $ssl): void
    {
        $this->ssl = $ssl;
    }

    public function options()
    {
        return $this->options;
    }
}
