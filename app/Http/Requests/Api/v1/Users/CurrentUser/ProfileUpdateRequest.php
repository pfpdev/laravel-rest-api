<?php

namespace App\Http\Requests\Api\v1\Users\CurrentUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'string|min:1|max:100',
            'last_name' => 'string|min:1|max:100',
            'email' => [
                'email',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'phone' => [
                'regex:/^\+?[1-9]\d{7,14}$/',
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please add your mobile number in an international format. Eg: +40700222999',
        ];
    }
}
