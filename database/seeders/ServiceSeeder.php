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
                'name'              => 'Air Conditioning Services',
                'description'       => 'Indoor & Outdoor Unit Installation. Indoor & Outdoor Unit Repair and Maintenance',
                'section_name'      => 'Aircon',
            ],
            [
                'name'              => 'TV & Antenna Services',
                'description'       => 'TV Installation and Setup .Antenna Installation and Alignment .TV and Antenna Repair Services',
                'section_name'      => 'TV & Antenna ',
            ],
            [
                'name'              => 'Refrigerator Services',
                'description'       => 'Refrigerator Installation. Refrigerator Repair and Maintenance.',
                'section_name'      => 'Refrigerator',
            ],
            [
                'name'              => 'Washing Machine Services',
                'description'       => 'Washing Machine Installation. Washing Machine Repair and Maintenance.',
                'section_name'      => 'Washing Machine',
            ]
        ];

        $payload = [];
        foreach ($services as $s) {
            $section = Section::where('name', $s['section_name'])->first();
            $payload[] = [
                'name' => $s['name'],
                'description' => $s['description'],
                'section_id' => $section ? $section->id : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Service::insert($payload);
    }
}

