<?php

namespace App\Http\Requests\Api\v1\Cities;

use Illuminate\Foundation\Http\FormRequest;

class CityIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public endpoint
    }

    public function rules(): array
    {
        return [
            'county_id'   => ['sometimes', 'integer', 'exists:counties,id'],
            'county_slug' => ['sometimes', 'string', 'max:64', 'exists:counties,slug'],
        ];
    }

    public function messages(): array
    {
        return [
            'county_id.exists'   => 'The selected county_id does not exist.',
            'county_slug.exists' => 'The selected county_slug does not exist.',
        ];
    }
}
