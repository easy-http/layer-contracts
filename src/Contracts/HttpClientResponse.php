<?php

namespace EasyHttp\LayerContracts\Contracts;

use EasyHttp\LayerContracts\Exceptions\ImpossibleToParseJsonException;

interface HttpClientResponse
{
    public function getStatusCode(): int;
    public function getHeaders(): array;
    public function getBody(): string;

    /**
     * @return array
     * @throws ImpossibleToParseJsonException
     */
    public function parseJson(): array;
}
