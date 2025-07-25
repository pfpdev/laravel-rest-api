<?php

namespace App\Http\Resources\Api\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // In here, we format the response, how we see fit, taking into account the
        // data that was passed to the constructor when this class was instantiated.
        // This class it's only for formatting the response, so use it ONLY for that.
        // That means: no DB queries, no complex computations. That should be achieved
        // in the service class where the data is coming from
        return [
            'message' => 'Account registered successfully.',
            'data' => [
                'username' => $request->username,
            ]
        ];
    }
}
