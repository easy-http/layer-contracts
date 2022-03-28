<?php

namespace EasyHttp\LayerContracts\Contracts;

interface HttpClientRequest
{
    public function getMethod(): string;
    public function getUri(): string;
    public function getJson(): array;
    public function getQuery(): array;
    public function getHeader(string $key);
    public function setMethod(string $method): self;
    public function setUri(string $uri): self;
    public function setHeader(string $key, string $value): self;
    public function setJson(array $json): self;
    public function setQuery(array $query): self;

    /**
     * SSL Client Verification
     * We suggest this parameter will be false by default.
     *
     * @param bool $ssl
     * @return void
     */
    public function ssl(bool $ssl): void;
}
