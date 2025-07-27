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
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:1|max:100',
            'last_name' => 'required|string|min:1|max:100',
            // as we'll be logging in users in our system, through email or
            // phone number we want to make sure that the account that gets
            // registered, hasn't been already registered. thus the unique
            // rule for both phone and email
            'email' => 'required|email|unique:users,email',
            'phone' => [
                'required',
                'unique:users,phone',
                'regex:/^\+?[1-9]\d{7,14}$/'
            ],
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            // we want to return to the client, and explicit message to understand how to format the phone number
            'phone.regex' => 'Please add your mobile number an in international format. Eg: +40700222999',
        ];
    }
}
