<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Locations\StoreRequest;
use App\Http\Requests\Api\v1\Locations\UpdateRequest;
use App\Http\Resources\Api\v1\Locations\LocationResource;
use App\Models\Location;
use App\Services\Api\v1\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LocationController extends Controller
{
    public function __construct(private readonly LocationService $service) {}

    public function index(): ResourceCollection
    {
        $locations = $this->service->listForUser(auth()->id());

        return LocationResource::collection($locations);
    }

    public function store(StoreRequest $request): LocationResource
    {
        $location = $this->service->create($request->validated(), auth()->id());

        return new LocationResource($location);
    }

    public function show(Location $location): LocationResource
    {
        return new LocationResource($location->load('hours'));
    }

    public function update(UpdateRequest $request, Location $location): LocationResource
    {
        $updated = $this->service->update($location, $request->validated());

        return new LocationResource($updated);
    }

    public function destroy(Location $location): JsonResponse
    {
        $this->service->delete($location);

        return response()->json(['message' => 'Deleted.'], 204);
    }

    public function activate(Location $location): LocationResource
    {
        return new LocationResource($this->service->setActive($location, true));
    }

    public function deactivate(Location $location): LocationResource
    {
        return new LocationResource($this->service->setActive($location, false));
    }

    public function archive(Location $location): LocationResource
    {
        return new LocationResource($this->service->archive($location));
    }
}
