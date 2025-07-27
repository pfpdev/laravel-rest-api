<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\RegisterRequest;
use App\Http\Resources\Api\v1\Auth\RegisterResource;
use App\Services\Api\v1\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): RegisterResource
    {
        $user = (new AuthService())->register($request->validated());

        // if the service has not successfully created the new user we'll return a generic
        // server error, and internally, we'll investigate, the problems, in the error logs
        // saved in the exception handling from the service
        if( $user === null) {
            abort(500);
        }

        return new RegisterResource($user);
    }
}
