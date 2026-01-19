<?php

namespace Database\Seeders;

use App\Models\Service;
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
                'section_id' => 9,
                'name' => 'Air Conditioning Services',
                'description' => '
                    <ul>
                        <li>Indoor & Outdoor Unit Installation</li>
                        <li>Indoor & Outdoor Unit Repair and Maintenance</li>
                    </ul>
                ',
            ],
            [
                'section_id' => 9,
                'name' => 'TV & Antenna Services',
                'description' => '
                    <ul>
                        <li>TV Installation and Setup</li>
                        <li>Antenna Installation and Alignment</li>
                        <li>TV and Antenna Repair Services</li>
                    </ul>
                ',
            ],
            [
                'section_id' => 9,
                'name' => 'Refrigerator Services',
                'description' => '
                    <ul>
                        <li>Refrigerator Installation</li>
                        <li>Refrigerator Repair and Maintenance</li>
                    </ul>
                ',
            ],
            [
                'section_id' => 9,
                'name' => 'Washing Machine Services',
                'description' => '
                    <ul>
                        <li>Washing Machine Installation</li>
                        <li>Washing Machine Repair and Maintenance</li>
                    </ul>
                ',
            ],
        ];

        $payload = [];

        foreach ($services as $service) {
            $payload[] = [
                'section_id' => $service['section_id'],
                'name' => $service['name'],
                'description' => $service['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Service::insert($payload);
    }
}
