<?php

namespace EasyHttp\LayerContracts\Tests\Unit\Example;

use EasyHttp\LayerContracts\Contracts\HttpClientAdapter;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use EasyHttp\LayerContracts\Contracts\HttpClientResponse;

class ClientAdapter implements HttpClientAdapter
{
    public function request(HttpClientRequest $request): HttpClientResponse
    {
        $response = $this->call($request->getMethod(), $request->getUri());
        return new ClientResponse($response);
    }

    private function call(string $method, string $uri): array
    {
        return [
            'status' => 200,
            'headers' => ['Server' => 'Apache/2.4.38 (Debian)'],
            'body' => '{"key":"value"}',
        ];
    }
}
