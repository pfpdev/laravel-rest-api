<?php

namespace App\Http\Resources\Api\v1\Locations;

use Illuminate\Http\Resources\Json\JsonResource;

class OpeningHoursResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'message' => 'Opening hours updated.',
            'data' => [
                'mon' => ['open' => $this->mon_open, 'close' => $this->mon_close],
                'tue' => ['open' => $this->tue_open, 'close' => $this->tue_close],
                'wed' => ['open' => $this->wed_open, 'close' => $this->wed_close],
                'thu' => ['open' => $this->thu_open, 'close' => $this->thu_close],
                'fri' => ['open' => $this->fri_open, 'close' => $this->fri_close],
                'sat' => ['open' => $this->sat_open, 'close' => $this->sat_close],
                'sun' => ['open' => $this->sun_open, 'close' => $this->sun_close],
            ],
        ];
    }
}
