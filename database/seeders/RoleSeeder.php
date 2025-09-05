<?php

namespace Database\Seeders;

use App\Enums\RoleSlug;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['scope' => 'admin',    'slug' => RoleSlug::ADMIN_SUPER->value,   'name' => 'Super Admin'],
            ['scope' => 'admin',    'slug' => RoleSlug::ADMIN_STAFF->value,   'name' => 'Admin Staff'],
            ['scope' => 'business', 'slug' => RoleSlug::BUSINESS_OWNER->value,'name' => 'Business Owner'],
            ['scope' => 'business', 'slug' => RoleSlug::BUSINESS_STAFF->value,'name' => 'Business Staff'],
        ];

        foreach ($defaults as $row) {
            Role::firstOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
