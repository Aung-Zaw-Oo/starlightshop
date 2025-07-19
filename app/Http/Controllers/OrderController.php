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

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if($order->order_status == 'pending') {
            $order->order_status = $request->status;
            $order->save();
        }

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    public function reorder($productId)
    {
        $product = Product::findOrFail($productId);

        return response()->json([
            'id'       => $product->id,
            'name'     => $product->name,
            'price'    => $product->price,
            'image'    => $product->image,
            'category' => $product->category->name ?? '',
            'stockQty' => $product->quantity,
        ]);
    }
}
