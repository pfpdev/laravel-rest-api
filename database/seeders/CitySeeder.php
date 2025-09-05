<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        // Fetch county ids by slug
        $countyIds = DB::table('counties')
            ->whereIn('slug', ['bucharest','cluj','mures'])
            ->pluck('id','slug');

        // --- Bucharest sectors (treated as cities for your schema) ---
        $bucharestCities = [
            ['name' => 'Sector 1', 'slug' => 'sector-1', 'county_slug' => 'bucharest'],
            ['name' => 'Sector 2', 'slug' => 'sector-2', 'county_slug' => 'bucharest'],
            ['name' => 'Sector 3', 'slug' => 'sector-3', 'county_slug' => 'bucharest'],
            ['name' => 'Sector 4', 'slug' => 'sector-4', 'county_slug' => 'bucharest'],
            ['name' => 'Sector 5', 'slug' => 'sector-5', 'county_slug' => 'bucharest'],
            ['name' => 'Sector 6', 'slug' => 'sector-6', 'county_slug' => 'bucharest'],
        ];

        // --- Cluj: top 3 by population ---
        $clujCities = [
            ['name' => 'Cluj-Napoca', 'slug' => 'cluj-napoca', 'county_slug' => 'cluj'],
            ['name' => 'Turda',       'slug' => 'turda',       'county_slug' => 'cluj'],
            ['name' => 'Dej',         'slug' => 'dej',         'county_slug' => 'cluj'],
        ];

        // --- Mureș: top 3 by population ---
        $muresCities = [
            ['name' => 'Târgu Mureș', 'slug' => 'targu-mures', 'county_slug' => 'mures'],
            ['name' => 'Reghin',      'slug' => 'reghin',      'county_slug' => 'mures'],
            ['name' => 'Sighișoara',  'slug' => 'sighisoara',  'county_slug' => 'mures'],
        ];

        $rows = array_merge($bucharestCities, $clujCities, $muresCities);

        foreach ($rows as $row) {
            $countyId = $countyIds[$row['county_slug']] ?? null;
            if (!$countyId) {
                // Skip if county not found (defensive)
                continue;
            }

            DB::table('cities')->updateOrInsert(
                ['slug' => $row['slug']],
                [
                    'county_id'  => $countyId,
                    'name'       => $row['name'],
                    'slug'       => $row['slug'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}
