<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full access to all system features including user management',
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'CRUD all website content; no user management access',
            ],
            [
                'name' => 'Normal User',
                'slug' => 'guest',
                'description' => 'No access to the admin dashboard',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
