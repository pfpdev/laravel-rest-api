<?php

namespace App\Http\Requests\Api\v1\Users\CurrentUser;

use Illuminate\Foundation\Http\FormRequest;
use Closure;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'password' => [
                'required',
                'string',
                'min:6',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        $fail("The current {$attribute} is invalid.");
                    }
                },
            ],
            'new_password' => ['required', 'string', 'min:6', 'different:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.current_password' => 'The current password you entered is incorrect.',
            'new_password.different'    => 'Your new password must be different from your current password.',
        ];
    }
}
