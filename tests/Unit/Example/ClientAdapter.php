<?php

namespace EasyHttp\LayerContracts\Tests\Unit\Example;

use EasyHttp\LayerContracts\Contracts\HttpClientAdapter;
use EasyHttp\LayerContracts\Contracts\HttpClientRequest;
use EasyHttp\LayerContracts\Contracts\HttpClientResponse;

class ClientAdapter implements HttpClientAdapter
{
    protected $handler;

    public function setHandler(callable $handler): void
    {
        $this->handler = $handler;
    }

    public function request(HttpClientRequest $request): HttpClientResponse
    {
        $response = $this->call($request->getMethod(), $request->getUri());
        return new ClientResponse($response);
    }

    private function call(string $method, string $uri): array
    {
        if ($this->handler) {
            return call_user_func($this->handler);
        }

        return [
            'status' => 200,
            'headers' => [
                'Server' => 'Apache/2.4.38 (Debian)',
                'X-Info' => $method . ' ' . $uri
            ],
            'body' => '{"key":"value"}',
        ];
    }
}
