<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Http\Requests\Api\v1\Auth\RegisterRequest;
use App\Http\Resources\Api\v1\Auth\LoginResource;
use App\Http\Resources\Api\v1\Auth\RegisterResource;
use App\Services\Api\v1\AuthService;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): RegisterResource
    {
        $user = (new AuthService())->register($request->validated());

        if( $user === null) {
            abort(500);
        }

        return new RegisterResource($user);
    }

    public function login(LoginRequest $request): LoginResource
    {
        $user = (new AuthService())->login($request->validated());

        if( $user === null) {
            abort(401, 'Please check your credentials.');
        }

        return new LoginResource($user);
    }
}
