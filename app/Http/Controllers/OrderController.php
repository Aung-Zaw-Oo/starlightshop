<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->paginate(10);
        return view('admin.order', compact('orders'));
    }

    public function cart()
    {
        return view('customer.cart');
    }

    public function orderHistory()
    {
        $customerId = session('customer_id');

        $orders = Order::with('orderDetails.product')
            ->where('customer_id', session('customer_id'))
            ->paginate(10);

        return view('customer.order_history', compact('orders'));
    }

    public function reorder($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
                'image' => $product->image ?? 'default.jpg', // fallback if null
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('customer.cart')->with('success', $product->name . ' has been added to your cart again.');
    }

}
