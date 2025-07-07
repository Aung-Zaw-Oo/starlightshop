<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

    public function reorder(){
        
    }

}
