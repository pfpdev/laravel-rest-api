<?php

namespace App\Http\Resources\Api\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Login successful.',
            'data' => [
                'token' => $this->jwt,
            ]
        ];
    }
}
