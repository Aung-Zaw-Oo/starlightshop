<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Order::create([
                'customer_id' => rand(1, 20),
                'payment_type' => '4242-xxxx-xxxx-xxxx',
                'order_date' => now(),
                'total_price' => 0,
                'qty' => 0,
                'order_status' => 'pending',
                'status' => 'active',
            ]);
        }
    }
}
