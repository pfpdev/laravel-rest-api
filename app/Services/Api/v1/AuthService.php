<?php

namespace App\Services\Api\v1;

use App\Models\User;

class AuthService
{
    public function register(array $inputData): ?User
    {
        try {
            // remember that the $inputData, as sent from the controller, it's gathering
            // all the validated data as defined in the RegisterRequest::rules() method.
            // through that, we'll ensure that all the data needed for the model is being gathered
            // and also validated to ensure it can be stored in the users table
            $user = User::create($inputData);
            $token = $user->createToken('apiToken');
            $user->jwt = $token->plainTextToken;

            return $user;
        } catch (\Exception $exception) {
            // if the creation of the user, in the users table, fails,
            // this will catch any kind of Exceptions that could occur.
            // It's your job to decide, yourself or within your team what
            // to do in a case like this.
        }

        return null;
    }
}
