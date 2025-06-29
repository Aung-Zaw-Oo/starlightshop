<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        $orders = Order::all();

        foreach ($orders as $order) {
            $totalQty = 0;
            $totalPrice = 0;

            $orderProducts = $products->random(rand(1, 3));

            foreach ($orderProducts as $product) {
                $qty = rand(1, 2);
                $price = $product->sale_price;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                    'status' => 'active',
                ]);

                $totalQty += $qty;
                $totalPrice += $price * $qty;
            }

            $order->update([
                'qty' => $totalQty,
                'total_price' => $totalPrice,
            ]);
        }
    }
}
