<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@gmail.com',
                'phone'    => '09797809783',
                'password' => bcrypt('password'),
                'status'   => true,
            ],
            [
                'name'     => 'Manager',
                'email'    => 'manager@gmail.com',
                'phone'    => '09406405233',
                'password' => bcrypt('password'),
                'status'   => true,
            ],
            [
                'name'     => 'Staff',
                'email'    => 'staff@gmail.com',
                'phone'    => '09406405234',
                'password' => bcrypt('password'),
                'status'   => true,
            ],
            [
                'name'     => 'User',
                'email'    => 'user@gmail.com',
                'phone'    => '09406405235',
                'password' => bcrypt('password'),
                'status'   => true,
            ],
            [
                'name'     => 'Guest',
                'email'    => 'guest@gmail.com',
                'phone'    => '09406405235',
                'password' => bcrypt('password'),
                'status'   => true,
            ],
        ];

        foreach ($users as $user) {
            $userData = User::where('email', $user['email'])->first();
            if (! $userData) {
                User::create($user);
            }
        }
    }
}
