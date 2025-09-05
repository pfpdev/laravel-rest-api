<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountySeeder extends Seeder
{
    public function run(): void
    {
        $counties = [
            ['name' => 'Bucuresti', 'slug' => 'bucuresti'],
            ['name' => 'Cluj',      'slug' => 'cluj'],
            ['name' => 'Mureș',     'slug' => 'mures'],
        ];

        foreach ($counties as $c) {
            DB::table('counties')->updateOrInsert(
                ['slug' => $c['slug']],
                [
                    'name'       => $c['name'],
                    'slug'       => $c['slug'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ],
            );
        }
    }
}
