<?php

namespace App\Http\Resources\Api\v1\Users\CurrentUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'reminder_email' => $this->reminder_email,
            'reminder_sms' => $this->reminder_sms,
            'booking_updates' => $this->booking_updates,
            'marketing_email' => $this->marketing_email,
        ];
    }
}
