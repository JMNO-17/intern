<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name'        => 'Aricon Product 1',
                'slug'        => 'product-1',
                'section_id' => 4,
            ],
            [
                'name'        => 'TV Product 1',
                'slug'        => 'product-2',
                'section_id' => 5,
            ],
            [
                'name'        => 'Washing Machine Product 1',
                'slug'        => 'product-3',
                'section_id' => 6,
            ],
            [
                'name'        => 'Refrigerator Product 1',
                'slug'        => 'product41',
                'section_id' => 7,
            ],
            [
                'name'        => 'Spare Parts Product 1',
                'slug'        => 'product-5',
                'section_id' => 8,
            ],
            
        ];

        $payload = [];
        foreach ($products as $p) {
            $payload[] = [
                'name' => $p['name'],
                'slug' => $p['slug'],
                'section_id' => $p['section_id'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Product::insert($products);
    }
}
