<?php

namespace App\Http\Resources\Api\v1\Locations;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'name'         => $this->name,
            'email'        => $this->email,
            'phone1'       => $this->phone1,
            'phone2'       => $this->phone2,
            'address'      => $this->address,
            'description'  => $this->description,
            'url_website'  => $this->url_website,
            'url_facebook' => $this->url_facebook,
            'url_twitter'  => $this->url_twitter,
            'url_tiktok'   => $this->url_tiktok,
            'city'          => $this->city,
            'active'       => (bool) $this->active,
            'archived'     => (bool) $this->archived,
            'hours'        => $this->whenLoaded('hours', fn () => new OpeningHoursResource($this->hours)),
            'created_at'   => $this->created_at?->toISOString(),
            'updated_at'   => $this->updated_at?->toISOString(),
        ];
    }
}
