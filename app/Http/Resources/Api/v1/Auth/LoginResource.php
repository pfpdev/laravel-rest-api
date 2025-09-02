<?php

namespace App\Http\Resources\Api\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'message' => 'Login successful.',
            'data' => [
                'token' => $this->jwt,
            ]
        ];

        if ($this->email === 'admin@paws.com') {
            $data['data']['admin'] = true;
        }

        return $data;
    }
}
