<?php

namespace App\Http\Requests\Api\v1\Locations;

use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('delete', $this->route('location'));
    }

    public function rules(): array
    {
        return [];
    }
}
