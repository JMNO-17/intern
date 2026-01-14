<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'name'          => 'Home',
                'menu_id'       => 1,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'About Us',
                'menu_id'       => 2,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Why Choose Lin Oo?',
                'menu_id'       => 2,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Aircon',
                'menu_id'       => 3,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'TV & Antenna ',
                'menu_id'       => 3,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Washing Machine',
                'menu_id'       => 3,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Refrigerator',
                'menu_id'       => 3,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Electronic Spare Parts ',
                'menu_id'       => 3,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Services',
                'menu_id'       => 4,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            [
                'name'          => 'Contact Details',
                'menu_id'       => 5,
                'created_at'    => Carbon::now()->format('Y-m-d'),
                'updated_at'    => Carbon::now()->format('Y-m-d'),
            ],
            
        ];

        foreach ($sections as $section) {
            $sectionData = Section::where('name', $section['name'])->first();
            if (!$sectionData) {
                Section::create($section);
            }
        }
    }
}
