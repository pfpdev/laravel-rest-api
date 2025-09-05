<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationHour extends Model
{
    protected $table = 'location_hours';

    protected $fillable = [
        'location_id',
        'mon_open','mon_close',
        'tue_open','tue_close',
        'wed_open','wed_close',
        'thu_open','thu_close',
        'fri_open','fri_close',
        'sat_open','sat_close',
        'sun_open','sun_close',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
