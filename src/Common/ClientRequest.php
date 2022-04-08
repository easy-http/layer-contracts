<?php

namespace EasyHttp\LayerContracts\Common;

use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use EasyHttp\LayerContracts\Contracts\Request\HttpRequestSecurity;

class ClientRequest implements HttpClientRequest
{
    protected string $method;
    protected string $uri;
    protected array $headers = [];
    protected array $json = [];
    protected array $query = [];
    protected ?HttpRequestSecurity $securityContext = null;
    protected int $timeout = 10;
    protected array $basicAuth = [];
    protected bool $ssl = false;

    public function __construct(string $method, string $uri)
    {
        $this->method  = $method;
        $this->uri     = $uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHeader(string $key)
    {
        return $this->headers[$key] ?? null;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getJson(): array
    {
        return $this->json;
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getSecurityContext(): ?HttpRequestSecurity
    {
        return $this->securityContext;
    }

    public function getBasicAuth(): array
    {
        return $this->basicAuth;
    }

    public function hasJson(): bool
    {
        return !empty($this->json);
    }

    public function hasQuery(): bool
    {
        return !empty($this->query);
    }

    public function hasHeaders(): bool
    {
        return !empty($this->headers);
    }

    public function hasSecurityContext(): bool
    {
        return !is_null($this->getSecurityContext());
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function setHeaders(array $headers): self
    {
        foreach ($headers as $key => $value) {
            $this->setHeader($key, $value);
        }

        return $this;
    }

    public function setJson(array $json): self
    {
        $this->json = $json;

        return $this;
    }

    public function setQuery(array $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setSecurityContext(HttpRequestSecurity $securityContext): self
    {
        $this->securityContext = $securityContext;

        return $this;
    }

    public function setBasicAuth(string $username, string $password): self
    {
        $this->basicAuth = [$username, $password];

        return $this;
    }

    public function ssl(bool $ssl): self
    {
        $this->ssl = $ssl;

        return $this;
    }

    public function isSSL(): bool
    {
        return $this->ssl;
    }
}
