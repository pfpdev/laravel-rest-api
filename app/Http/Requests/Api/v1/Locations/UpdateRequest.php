<?php

namespace App\Http\Requests\Api\v1\Locations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->route('location'));
    }

    public function rules(): array
    {
        return [
            'name'         => ['sometimes','string','max:255'],
            'email'        => ['nullable','email','max:255'],
            'phone1'       => ['nullable','string','max:32'],
            'phone2'       => ['nullable','string','max:32'],
            'address'      => ['nullable','string','max:512'],
            'description'  => ['nullable','string'],
            'url_website'  => ['nullable','url','max:255'],
            'url_facebook' => ['nullable','url','max:255'],
            'url_twitter'  => ['nullable','url','max:255'],
            'url_tiktok'   => ['nullable','url','max:255'],
            'city_id'      => ['nullable','integer','exists:cities,id'],
            'active'       => ['sometimes','boolean'],
            'archived'     => ['sometimes','boolean'],
        ];
    }
}
