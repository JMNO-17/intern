<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key'           => 'favicon',
                'display_name'  => 'Favicon',
                'value'         => '/default_image.png',
            ],
            [
                'key'           => 'site_logo',
                'display_name'  => 'Site Logo',
                'value'         => '/default_image.png',
            ],
            [
                'key'           => 'site_name',
                'display_name'  => 'Site Name',
                'value'         => 'Z.com Myanmar',
            ],
            [
                'key'           => 'site_description',
                'display_name'  => 'Site Description',
                'value'         => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fringilla, lectus ac bibendum iaculis, dolor felis laoreet erat, vel fermentum lacus enim id lorem. Suspendisse faucibus sodales mauris, vitae rhoncus purus feugiat a. Cras id lacinia ligula. Ut pulvinar accumsan massa, in lacinia neque vehicula sit amet.',
            ],
            [
                'key'           => 'phone',
                'display_name'  => 'Phone',
                'value'         => '09770791678 ,09893392020 ',
            ],
            [
                'key'           => 'email',
                'display_name'  => 'Email',
                'value'         => 'linooelectronic@gmail.com',
            ],
            [
                'key'           => 'address',
                'display_name'  => 'Address',
                'value'         => 'No.110,Thingaha street, Beside Park, Hleguu Township.',
            ],
            [
                'key'           => 'seo_title',
                'display_name'  => 'SEO Title',
                'value'         => 'Admin Dashboard',
            ],
            [
                'key'           => 'seo_content',
                'display_name'  => 'SEO Content',
                'value'         => 'About Admin Dashboard',
            ],
            [
                'key'           => 'seo_keywords',
                'display_name'  => 'SEO Keywords',
                'value'         => 'Admin Dashboard',
            ],
            [
                'key'           => 'seo_enabled',
                'display_name'  => 'SEO Enabled',
                'value'         => '1',
            ],

            // footer section
            [
                'key'           => 'facebook',
                'display_name'  => 'Facebook',
                'value'         => 'https://www.facebook.com/',
            ],
            [
                'key'           => 'linkedin',
                'display_name'  => 'LinkedIn',
                'value'         => 'https://www.linkedin.com/',
            ],
            [
                'key'           => 'twitter',
                'display_name'  => 'Twitter',
                'value'         => 'https://www.twitter.com/',
            ],
            [
                'key'           => 'instragram',
                'display_name'  => 'Instragram',
                'value'         => 'https://www.instragram.com/',
            ],

            // for dynamic color
            [
                'key'           => 'default_bg_color',
                'display_name'  => 'Default Background Color',
                'value'         => '#00A54F', // #0D9B59 - #011B54 - #00A54F
            ],
            [
                'key'           => 'google_map',
                'display_name'  => 'Google Map',
                'value'         => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3818.511108688209!2d96.12626042492195!3d16.850592683947948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1952af70c1461%3A0x173ad4c3427759e1!2sMICT%20Park%2C%20Building%2018!5e0!3m2!1sen!2smm!4v1768468040283!5m2!1sen!2smm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            ],

            // quick links
            [
                'key'           => 'quick_link_a',
                'display_name'  => 'Quick Link A',
                'value'         => 'https://www.google.com/',
            ],
            [
                'key'           => 'quick_link_b',
                'display_name'  => 'Quick Link B',
                'value'         => 'https://www.google.com/',
            ],
            [
                'key'           => 'quick_link_c',
                'display_name'  => 'Quick Link C',
                'value'         => 'https://www.google.com/',
            ],
            [
                'key'           => 'quick_link_d',
                'display_name'  => 'Quick Link D',
                'value'         => 'https://www.google.com/',
            ],

            // useful links
            [
                'key'           => 'useful_link_a',
                'display_name'  => 'Useful Link A',
                'value'         => 'https://www.google.com/',
            ],
            [
                'key'           => 'useful_link_b',
                'display_name'  => 'Useful Link B',
                'value'         => 'https://www.google.com/',
            ],
            [
                'key'           => 'useful_link_c',
                'display_name'  => 'Useful Link C',
                'value'         => 'https://www.google.com/',
            ],
            [
                'key'           => 'useful_link_d',
                'display_name'  => 'Useful Link D',
                'value'         => 'https://www.google.com/',
            ],

        ];

        Setting::insert($settings);
    }
}
