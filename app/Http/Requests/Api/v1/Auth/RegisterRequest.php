<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // this needs to be set to true, as we're dealing with a public request
        // rules can be added here to allow/block users from using the request
        return true;
    }

    public function rules(): array
    {
        // the array keys below will be used when passing data from this request,
        // using the validated() method, to limit the data sent to the service
        return [
            'username' => 'required'
        ];
    }
}
