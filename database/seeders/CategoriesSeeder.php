<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'name' => 'Grooming & Beauty',
                'slug' => 'toaletare',
                'icon' => 'Scissors',
                'description' => 'Pet grooming & beauty services'
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'veterinar',
                'icon' => 'Stethoscope',
                'description' => 'Vet clinics & medical services'
            ],
            [
                'name' => 'Daily Care',
                'slug' => 'ingrijire-zilnica',
                'icon' => 'Heart',
                'description' => 'Overnight pet boarding & daycare'
            ],
            [
                'name' => 'Training & Behavior',
                'slug' => 'dresaj',
                'icon' => 'GraduationCap',
                'description' => 'Obedience & behavior training'
            ],
        ];

        foreach ($rows as $row) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $row['slug']],
                [
                    'name'        => $row['name'],
                    'slug'        => $row['slug'],
                    'icon'        => $row['icon'],
                    'description' => $row['description'],
                    'updated_at'  => now(),
                    'created_at'  => now(),
                ],
            );
        }
    }
}
