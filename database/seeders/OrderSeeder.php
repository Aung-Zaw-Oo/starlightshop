<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Order::create([
                'customer_id' => rand(1, 6),
                'payment_type' => 'cash',
                'order_date' => now(),
                'total_price' => 0,
                'qty' => 0,
                'order_status' => 'pending',
                'status' => 'active',
            ]);
        }
    }
}
