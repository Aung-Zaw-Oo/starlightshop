<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 3; $i++) {
                $purchase_price = rand(50, 100);
                $sale_price = $purchase_price + rand(20, 50);

                Product::create([
                    'category_id' => $category->id,
                    'staff_id' => 1,
                    'name' => $category->name . " Product $i",
                    'sale_price' => $sale_price,
                    'purchase_price' => $purchase_price,
                    'qty' => rand(1, 20),
                    'description' => "Description for {$category->name} Product $i",
                    'image' => null,
                    'status' => 'active',
                ]);
            }
        }
    }
}
