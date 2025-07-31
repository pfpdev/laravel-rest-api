<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Users\CurrentUserResource;
use Illuminate\Support\Facades\Request;


class UserController extends Controller
{
    public function getCurrentUserDetails(Request $request): CurrentUserResource
    {
        return new CurrentUserResource(auth()->user());
    }
}
