<?php

namespace App\Http\Resources\Api\v1\Cities;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\v1\Counties\CountyResource;

class CityResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'slug'      => $this->slug,
            'name'      => $this->name,
            'county_id' => $this->county_id,
            'county'    => new CountyResource($this->whenLoaded('county')),
        ];
    }
}
