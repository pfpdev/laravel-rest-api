<?php

namespace App\Policies;

use App\Enums\RoleSlug;
use App\Models\Location;
use App\Models\User;

class LocationPolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            RoleSlug::ADMIN_SUPER,
            RoleSlug::ADMIN_STAFF,
            RoleSlug::BUSINESS_OWNER,
        ]);
    }

    public function update(User $user, Location $location): bool
    {
        return $this->isManager($user, $location);
    }

    public function delete(User $user, Location $location): bool
    {
        return $this->isManager($user, $location);
    }

    public function deactivate(User $user, Location $location): bool
    {
        return $this->isManager($user, $location);
    }

    public function activate(User $user, Location $location): bool
    {
        return $this->isManager($user, $location);
    }

    public function archive(User $user, Location $location): bool
    {
        return $this->isManager($user, $location);
    }

    protected function isOwner(User $user, Location $location): bool
    {
        return $location->user_id === $user->id;
    }

    protected function isAdmin(User $user): bool
    {
        return $user->hasAnyRole([
            RoleSlug::ADMIN_SUPER,
            RoleSlug::ADMIN_STAFF,
        ]);
    }

    protected function isManager(User $user, Location $location): bool
    {
        return $this->isAdmin($user) || $this->isOwner($user, $location);
    }
}
