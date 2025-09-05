<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    protected $fillable = [
        'user_id','name','email','phone1','phone2','address','description',
        'url_website','url_facebook','url_twitter','url_tiktok','city_id',
        'active','archived',
    ];

    protected $casts = [
        'active' => 'boolean',
        'archived' => 'boolean',
    ];

    protected static function booted(): void
    {
        self::created(static function (self $location): void {
            $location->hours()->create();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function hours(): HasOne
    {
        return $this->hasOne(LocationHour::class);
    }
}
