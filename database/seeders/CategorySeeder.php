<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
        'Desktops',
        'Laptops',
        'CPU',
        'GPU',
        'Motherboards',
        'Cases',
        'Monitors',
        'Accessories',
        'Software'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'image' => null,
                'status' => 'active'
            ]);
        }
    }
}
