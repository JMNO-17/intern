<?php

namespace Database\Seeders;

use App\Models\BannerSlider;
use Illuminate\Database\Seeder;

class BannerSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerSliders = [
            [
                'section_id'        => 1,
                'name'              => 'Banner Slider 1',
                'description'       => 'Banner Slider 1 Description',
            ],
        ];

        BannerSlider::insert($bannerSliders);
    }
}
