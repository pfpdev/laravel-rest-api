<?php

namespace App\Models;

use App\Enums\RoleSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        self::created(static function (self $user): void {
            // upon a successful user creation, we'll create the notification
            // settings automatically, based on the default values from the
            // DB schema and the notifications-user relationship in the models
            $user->notifications()->create();
        });
    }

    public function notifications(): HasOne
    {
        return $this->hasOne(Notification::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole(RoleSlug|string $role): bool
    {
        $slug = $role instanceof RoleSlug ? $role->value : $role;

        return $this->roles->contains('slug', $slug);
    }

    /** @param array<int,RoleSlug|string> $roles */
    public function hasAnyRole(array $roles): bool
    {
        $slugs = array_map(fn($r) => $r instanceof RoleSlug ? $r->value : $r, $roles);

        return $this->roles->pluck('slug')->intersect($slugs)->isNotEmpty();
    }

    public function isAdminScope(): bool
    {
        return $this->roles->contains(fn($r) => $r->scope === 'admin');
    }

    public function isBusinessScope(): bool
    {
        return $this->roles->contains(fn($r) => $r->scope === 'business');
    }
}
