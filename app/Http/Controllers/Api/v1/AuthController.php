<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\RegisterRequest;
use App\Http\Resources\Api\v1\Auth\RegisterResource;
use App\Services\Api\v1\AuthService;

class AuthController extends Controller
{
    // We're passing in the controller action, the RegisterRequest which
    // we'll use to validate the basic data that we're sending in the request
    public function register(RegisterRequest $request): RegisterResource
    {
        // We're passing to the Service ONLY the data that has been validated.
        // The field inputs that are mentioned in RegisterRequest::rules() method.
        // This prevents unnecessary or potentially unsecure data to be passed to
        // the service and/or even further to data handlers and data sources
        $registrationData = (new AuthService())->register($request->validated());

        // We then use the Resource class to format the data
        // coming from the service, for the HTTP reponse
        return new RegisterResource($registrationData);
    }
}
