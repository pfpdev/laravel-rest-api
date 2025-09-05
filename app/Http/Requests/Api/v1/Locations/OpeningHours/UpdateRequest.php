<?php

namespace App\Http\Requests\Api\v1\Locations\OpeningHours;

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
        // Accept a location_id and any subset of *_open/*_close as H:i (or H:i:s)
        $time = ['date_format:H:i','sometimes']; // Allow "09:00"
        $timeWithSeconds = ['date_format:H:i:s','sometimes'];
        // Accept either format
        $either = ['sometimes','regex:/^\d{2}:\d{2}(:\d{2})?$/'];

        return [
            'location_id' => ['required','integer','exists:locations,id'],
            'mon_open' => $either, 'mon_close' => $either,
            'tue_open' => $either, 'tue_close' => $either,
            'wed_open' => $either, 'wed_close' => $either,
            'thu_open' => $either, 'thu_close' => $either,
            'fri_open' => $either, 'fri_close' => $either,
            'sat_open' => $either, 'sat_close' => $either,
            'sun_open' => $either, 'sun_close' => $either,
        ];
    }
}
