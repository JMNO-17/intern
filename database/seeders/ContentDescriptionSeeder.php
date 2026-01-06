<?php

namespace Database\Seeders;

use App\Models\ContentDescription;
use Illuminate\Database\Seeder;

class ContentDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content_descriptions = [
            [

                'section_id'        => 1,
                'title'             => 'Title One',
                'slug'              => 'title-one',
                'description'       => 'Description One'
            ],
            [
                'section_id'        => 1,
                'title'             => 'Title Two',
                'slug'              => 'title-two',
                'description'       => 'Description Two'
            ],
            [
                'section_id'        => 1,
                'title'             => 'Title Three',
                'slug'              => 'title-three',
                'description'       => 'Description Three'
            ]
        ];

        ContentDescription::insert($content_descriptions);
    }
}
