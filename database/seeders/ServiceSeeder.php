<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'section_id'        => 9,
                'name'              => 'Air Conditioning Services',
               'description' => '

               <li>Indoor & Outdoor Unit Installation</li>
                <li>Indoor & Outdoor Unit Repair and Maintenance</li>
                ',
            ],
            [
                'section_id'        => 9,
                'name'              => 'TV & Antenna Services',
                'description'       => 
                '
                    <li>TV Installation and Setup.</li>
                    <li>Antenna Installation and Alignment.</li>
                    <li>TV and Antenna Repair Services.</li>
                ',
            ],
            [
                'section_id'        => 9,
                'name'              => 'Refrigerator Services',
                'description'       => '
                 <li>Refrigerator Installation. </li>
                 <li>Refrigerator Repair and Maintenance.</li>',
            ],
            [
                'section_id'        => 9,
                'name'              => 'Washing Machine Services',
                'description'       => '
                     <li>Washing Machine Installation.</li>
                     <li>Washing Machine Repair and Maintenance.</li>
               ',
               
            ]
        ];

        $payload = [];
        foreach ($services as $s) {
            $payload[] = [
                'name' => $s['name'],
                'description' => $s['description'],
                'section_id' => $s['section_id'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Service::insert($payload);
    }
}

