<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Locations\OpeningHours\UpdateRequest;
use App\Http\Resources\Api\v1\Locations\OpeningHoursResource;
use App\Models\Location;
use App\Services\Api\v1\LocationService;

class OpeningHoursController extends Controller
{
    public function __construct(private readonly LocationService $service) {}
    public function update(UpdateRequest $request): OpeningHoursResource
    {
        $data = $request->validated();

        /** @var \App\Models\Location $location */
        $location = Location::with('hours')->findOrFail($data['location_id']);
        $this->authorize('update', $location);

        $hours = $this->service->updateOpeningHours($location, $data);

        return new OpeningHoursResource($hours);
    }
}
