<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'reminder_email',
        'reminder_sms',
        'booking_updates',
        'marketing_email',
    ];

    protected $casts = [
        'reminder_email' => 'boolean',
        'reminder_sms' => 'boolean',
        'booking_updates' => 'boolean',
        'marketing_email' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
