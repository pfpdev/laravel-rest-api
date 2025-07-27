<?php

namespace App\Http\Resources\Api\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Account created successfully.',
            'data' => [
                'token' => $this->jwt,
            ]
        ];
    }
}
