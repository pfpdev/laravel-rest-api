<?php

namespace App\Services\Api\v1;

use App\Enums\RoleSlug;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $inputData): ?User
    {
        try {
            $user = User::create($inputData);
            $user->roles()->attach(Role::where('slug', RoleSlug::BUSINESS_OWNER->value)->first()->id);
            $token = $user->createToken('apiToken');
            $user->jwt = $token->plainTextToken;

            return $user;
        } catch (\Exception $exception) { }

        return null;
    }

    public function login(array $inputData): ?User
    {
        if(Auth::attempt($inputData)) {
            $user = Auth::user();
            $token = $user->createToken('apiToken');
            $user->jwt = $token->plainTextToken;

            return $user;
        }

        return null;
    }
}
