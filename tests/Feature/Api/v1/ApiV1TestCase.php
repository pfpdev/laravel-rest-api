<?php

namespace Tests\Feature\Api\v1;

use Tests\TestCase;

abstract class ApiV1TestCase extends TestCase
{
    protected string $apiPrefix = '/api/v1';

    protected function prefixApi(string $uri): string
    {
        // Prevent double-prefix if someone already passed a full URL
        if (str_starts_with($uri, $this->apiPrefix)) {
            return $uri;
        }

        // Ensure only one slash between prefix and endpoint
        return rtrim($this->apiPrefix, '/') . '/' . ltrim($uri, '/');
    }

    public function getJson($uri, array $headers = [], $options = 0)
    {
        return parent::getJson($this->prefixApi($uri), $headers, $options);
    }

    public function postJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::postJson($this->prefixApi($uri), $data, $headers, $options);
    }

    public function putJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::putJson($this->prefixApi($uri), $data, $headers, $options);
    }

    public function patchJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::patchJson($this->prefixApi($uri), $data, $headers, $options);
    }

    public function deleteJson($uri, array $data = [], array $headers = [], $options = 0)
    {
        return parent::deleteJson($this->prefixApi($uri), $data, $headers, $options);
    }
}
