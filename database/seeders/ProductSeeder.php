<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Men Slim Fit Jeans',
                'description' => 'Blue slim fit stretchable denim jeans',
                'price' => 1899,
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Women Kurti',
                'description' => 'Printed cotton kurti for casual wear',
                'price' => 1299,
                'stock' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Women Denim Jacket',
                'description' => 'Classic blue denim jacket with regular fit',
                'price' => 2199,
                'stock' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
