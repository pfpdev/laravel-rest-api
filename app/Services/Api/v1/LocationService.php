<?php

namespace App\Services\Api\v1;

use App\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LocationService
{
    public function listForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Location::where('user_id', $userId)
            ->latest('id')
            ->with('hours')
            ->paginate($perPage);
    }

    public function create(array $data, int $userId): Location
    {
        $data['user_id'] = $userId;
        $data['archived'] = $data['archived'] ?? false;
        $data['active'] = $data['active'] ?? true;

        return Location::create($data)->load('hours');
    }

    public function update(Location $location, array $data): Location
    {
        $location->update($data);
        return $location->fresh('hours');
    }

    public function delete(Location $location): void
    {
        $location->delete();
    }

    public function setActive(Location $location, bool $active): Location
    {
        $location->update(['active' => $active]);
        return $location->fresh('hours');
    }

    /**
     * Archive = set both inactive and archived
     */
    public function archive(Location $location): Location
    {
        $location->update(['active' => false, 'archived' => true]);
        return $location->fresh('hours');
    }

    public function updateOpeningHours(Location $location, array $data): Location
    {
        // Only update provided keys among *_open/*_close
        $allowed = [
            'mon_open','mon_close','tue_open','tue_close','wed_open','wed_close',
            'thu_open','thu_close','fri_open','fri_close','sat_open','sat_close',
            'sun_open','sun_close',
        ];

        $payload = array_intersect_key($data, array_flip($allowed));

        $location->hours()->update($payload);

        return $location->fresh('hours');
    }
}
