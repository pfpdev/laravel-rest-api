<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:1|max:100',
            'last_name' => 'required|string|min:1|max:100',
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
            'phone.regex' => 'Please add your mobile number an in international format. Eg: +40700222999',
        ];
    }
}
