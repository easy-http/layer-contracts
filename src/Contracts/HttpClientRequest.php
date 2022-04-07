<?php

namespace EasyHttp\LayerContracts\Contracts;

use EasyHttp\LayerContracts\Contracts\Request\HttpRequestSecurity;

interface HttpClientRequest
{
    public function getMethod(): string;
    public function getUri(): string;
    public function getHeader(string $key);

    /**
     * Returns an array with key -> value pairs of headers
     * Ex: ['Content-Type' => 'application/json;charset=UTF-8', 'Accept' => 'application/json']
     *
     * @return array
     */
    public function getHeaders(): array;

    public function getJson(): array;

    /**
     * Returns an array with key -> value pairs of query parameters
     * Ex: ['foo' => 'bar', 'flag' => 'enabled']
     *
     * @return array
     */
    public function getQuery(): array;

    public function getTimeout(): int;
    public function getSecurityContext(): ?HttpRequestSecurity;
    public function getBasicAuth(): array;

    public function hasJson(): bool;
    public function hasQuery(): bool;
    public function hasHeaders(): bool;
    public function hasSecurityContext(): bool;

    public function setMethod(string $method): self;
    public function setUri(string $uri): self;
    public function setHeader(string $key, string $value): self;
    public function setJson(array $json): self;
    public function setQuery(array $query): self;

    public function setTimeout(int $timeout): self;
    public function setSecurityContext(HttpRequestSecurity $securityContext): self;
    public function setBasicAuth(string $username, string $password): self;

    /**
     * SSL Client Verification
     * We suggest this parameter will be false by default.
     *
     * @param bool $ssl
     * @return void
     */
    public function ssl(bool $ssl): self;
    public function isSSL(): bool;
}
