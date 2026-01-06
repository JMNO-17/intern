<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
            ],
            [
                'name' => 'Manager',
            ],
            [
                'name' => 'Staff',
            ],
            [
                'name' => 'User',
            ],
            [
                'name' => 'Guest',
            ],
        ];

        foreach ($roles as $role) {
            $roleData = Role::where('name', $role['name'])->first();
            if (! $roleData) {
                Role::create($role);
            }
        }
    }
}
