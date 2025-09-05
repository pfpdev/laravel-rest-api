<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Cities\CityIndexRequest;
use App\Http\Resources\Api\v1\Cities\CityResource;
use App\Models\City;

class CityController extends Controller
{
    public function index(CityIndexRequest $request)
    {
        $data = $request->validated();

        $cities = City::query()
            ->with('county') // enables nested county in the resource when needed
            ->countyId($data['county_id'] ?? null)
            ->countySlug($data['county_slug'] ?? null)
            ->orderBy('name')
            ->get();

        return CityResource::collection($cities);
    }
}
