<?php

namespace App\Services\Api\v1;

class AuthService
{
    public function register(array $inputData): array
    {
        return [
            'username' => $inputData['username'],
        ];
    }
}
