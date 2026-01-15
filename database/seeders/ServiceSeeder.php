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
                <ul class="list-disc list-inside">
                    <li>Indoor & Outdoor Unit Installation</li>
                    <li>Indoor & Outdoor Unit Repair and Maintenance</li>
                </ul>',
            ],
            [
                'section_id'        => 9,
                'name'              => 'TV & Antenna Services',
                'description'       => 
                '<ul class="list-disc list-inside">
                    <li>TV Installation and Setup.</li>
                    <li>Antenna Installation and Alignment.</li>
                    <li> TV and Antenna Repair Services.</li>
                </ul>',
            ],
            [
                'section_id'        => 9,
                'name'              => 'Refrigerator Services',
                'description'       => '<ul class="list-disc list-inside">
                <li>Refrigerator Installation. </li>
                <li>Refrigerator Repair and Maintenance.</li>
                </ul>',
            ],
            [
                'section_id'        => 9,
                'name'              => 'Washing Machine Services',
                'description'       => '<ul class="list-disc list-inside">
                    <li> Washing Machine Installation.</li>
                    <li>Washing Machine Repair and Maintenance.</li>
                </ul>
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

