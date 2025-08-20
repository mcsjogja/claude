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
                'name' => 'Laptop ASUS VivoBook',
                'category' => 'Elektronik',
                'stock' => 10,
                'purchase_price' => 5000000.00,
                'selling_price' => 6500000.00,
            ],
            [
                'code' => 'PRD002',
                'name' => 'Mouse Wireless Logitech',
                'category' => 'Aksesoris',
                'stock' => 25,
                'purchase_price' => 150000.00,
                'selling_price' => 200000.00,
            ],
            [
                'code' => 'PRD003',
                'name' => 'Keyboard Mechanical',
                'category' => 'Aksesoris',
                'stock' => 15,
                'purchase_price' => 800000.00,
                'selling_price' => 1200000.00,
            ],
            [
                'code' => 'PRD004',
                'name' => 'Monitor LED 24 inch',
                'category' => 'Elektronik',
                'stock' => 8,
                'purchase_price' => 1500000.00,
                'selling_price' => 2000000.00,
            ],
            [
                'code' => 'PRD005',
                'name' => 'Headset Gaming',
                'category' => 'Aksesoris',
                'stock' => 20,
                'purchase_price' => 300000.00,
                'selling_price' => 450000.00,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
