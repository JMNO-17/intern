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
                'name'          => 'Banner Slider',
                'menu_id'       => 1,
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
