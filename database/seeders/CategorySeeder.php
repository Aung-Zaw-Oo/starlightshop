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
        'Laptops & Notebooks',
        'Desktops & All-in-Ones',
        'Monitors & Displays',
        'Computer Components',
        'Storage Devices',
        'Peripherals & Accessories',
        'Networking Equipment',
        'Printers & Scanners',
        'Software & Licenses',
        'Gaming Gear',
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
