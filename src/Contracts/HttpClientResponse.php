<?php

namespace EasyHttp\LayerContracts\Contracts;

use EasyHttp\LayerContracts\Exceptions\ResponseNotParsedException;

interface HttpClientResponse
{
    public function getStatusCode(): int;
    public function getHeaders(): array;

    /**
     * @return array
     * @throws ResponseNotParsedException
     */
    public function toJson(): array;
}
