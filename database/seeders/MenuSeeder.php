<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name'          => 'Home',
                'route_name'    => 'home',
                'slug'          => 'home',
            ],
            [
                'name'          => 'About Us',
                'route_name'    => 'aboutus',
                'slug'          => 'about-us',
            ],
            [
                'name'          => 'Contact Us',
                'route_name'    => 'contactus',
                'slug'          => 'contact-us',
            ]
        ];

        Menu::insert($menus);
    }
}
