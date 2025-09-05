<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'county_id',
        'name',
        'slug',
    ];

    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    /* Optional local scopes for clarity */
    public function scopeCountyId($query, ?int $countyId)
    {
        return $countyId ? $query->where('county_id', $countyId) : $query;
    }

    public function scopeCountySlug($query, ?string $slug)
    {
        if (!$slug) return $query;

        return $query->whereHas('county', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class)->withTimestamps();
    }
}
