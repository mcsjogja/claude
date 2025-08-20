<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'code' => 'PRD001',
                'name' => 'Laptop Acer Aspire 5',
                'category' => 'Elektronik',
                'stock' => 15,
                'purchase_price' => 6500000.00,
                'selling_price' => 7500000.00,
            ],
            [
                'code' => 'PRD002',
                'name' => 'Mouse Wireless Logitech',
                'category' => 'Aksesoris',
                'stock' => 50,
                'purchase_price' => 150000.00,
                'selling_price' => 200000.00,
            ],
            [
                'code' => 'PRD003',
                'name' => 'Keyboard Mechanical RGB',
                'category' => 'Aksesoris',
                'stock' => 25,
                'purchase_price' => 800000.00,
                'selling_price' => 1000000.00,
            ],
            [
                'code' => 'PRD004',
                'name' => 'Monitor LED 24 inch',
                'category' => 'Elektronik',
                'stock' => 10,
                'purchase_price' => 1800000.00,
                'selling_price' => 2200000.00,
            ],
            [
                'code' => 'PRD005',
                'name' => 'Headset Gaming HyperX',
                'category' => 'Gaming',
                'stock' => 30,
                'purchase_price' => 750000.00,
                'selling_price' => 950000.00,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
