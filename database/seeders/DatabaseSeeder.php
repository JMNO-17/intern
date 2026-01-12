<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            RoleUserTableSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
            SectionSeeder::class,
            BannerSliderSeeder::class,
            ContentDescriptionSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
