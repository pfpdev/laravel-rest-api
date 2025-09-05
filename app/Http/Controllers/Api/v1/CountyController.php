<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Counties\CountyResource;
use App\Models\County;

class CountyController extends Controller
{
    public function index()
    {
        $counties = County::query()
            ->orderBy('name')
            ->get();

        return CountyResource::collection($counties);
    }
}
