<?php

namespace EasyHttp\LayerContracts\Contracts;

interface EasyClientContract
{
    public function getRequest(): HttpClientRequest;
    public function call(string $method, string $uri): HttpClientResponse;
    public function request(string $method, string $uri): HttpClientRequest;
    public function withHandler(callable $handler): self;
    public function execute(): HttpClientResponse;
}
