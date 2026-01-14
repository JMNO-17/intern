<?php

namespace Database\Seeders;


use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abouts = [
            [
                'section_id'        => 2,
                'name'              => 'About Us',
                'description'       => 'Established in 2018 in Yangon, Myanmar, Lin Oo has rapidly emerged
                                        as a leading provider of electronic services and maintenance. We specialize in
                                        servicing and maintaining a wide range of top-tier brands, including Daikin,
                                        Chigo, Samsung, Mitsubishi, and Panasonic. Our commitment to excellence
                                        ensures that your electronic devices and systems receive the highest level of
                                        care and expertise.'
            ],
            [
                'section_id'        => 2,
                'name'              => 'Why Choose Lin Oo?',
                'description'       => '
                
                                        Brand Expertise: Specialized services for Daikin, Chigo, Samsung, Mitsubishi, and Panasonic.
                                        Quality Service: Commitment to excellence in every project.
                                        Customer-Centric: Tailored solutions designed to meet your unique needs.
                                        Skilled Technicians: Highly trained professionals with extensive experience. Since our inception, we have been proud to serve customers across

                                        Established in 2018 in Yangon, Myanmar, Lin Oo has rapidly emerged
                                            as a leading provider of electronic services and maintenance. We specialize in
                                            servicing and maintaining a wide range of top-tier brands, including Daikin,
                                            Chigo, Samsung , Mitsubishi, and Panasonic. Our commitment to excellence
                                            ensures that your electronic devices and  systems receive  the highest level of
                                            care and expertise.
                                        '
                                         
                                        

                                      
            ],
        ];

        About::insert($abouts);
    }
}
