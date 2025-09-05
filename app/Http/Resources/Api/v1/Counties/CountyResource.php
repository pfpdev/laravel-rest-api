<?php

namespace App\Http\Resources\Api\v1\Counties;

use Illuminate\Http\Resources\Json\JsonResource;

class CountyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            // Keep lean for /counties index; cities come from /cities endpoint
        ];
    }
}
