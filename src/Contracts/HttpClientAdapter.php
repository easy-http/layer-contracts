<?php

namespace EasyHttp\LayerContracts\Contracts;

use EasyHttp\LayerContracts\Exceptions\HttpClientException;

interface HttpClientAdapter
{
    /**
     * @param HttpClientRequest $request
     * @return HttpClientResponse
     * @throws HttpClientException
     */
    public function request(HttpClientRequest $request): HttpClientResponse;
}