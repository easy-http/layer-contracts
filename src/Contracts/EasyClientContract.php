<?php

namespace EasyHttp\LayerContracts\Contracts;

interface EasyClientContract
{
    public function getRequest(): HttpClientRequest;
    public function call(string $method, string $uri): HttpClientResponse;
    public function prepareRequest(string $method, string $uri): self;
    public function withHandler(callable $handler): self;
    public function execute(): HttpClientResponse;
}