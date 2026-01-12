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
                'name'        => 'Product 1',
                'slug'        => 'product-1',
                'category_id' => 1,
                'description' => 'Description for Product 1',
                'price'       => 19.99,
                'status'      => true,
            ],
            [
                'name'        => 'Product 2',
                'slug'        => 'product-2',
                'category_id' => 2,
                'description' => 'Description for Product 2',
                'price'       => 29.99,
                'status'      => true,
            ],
        ];

        Product::insert($products);
    }
}
