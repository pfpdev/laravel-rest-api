<?php

namespace App\Http\Requests\Api\v1\Users\CurrentUser;

use Illuminate\Foundation\Http\FormRequest;

class NotificationsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reminder_email'  => ['sometimes', 'boolean'],
            'reminder_sms'    => ['sometimes', 'boolean'],
            'booking_updates' => ['sometimes', 'boolean'],
            'marketing_email' => ['sometimes', 'boolean'],
        ];
    }
}
