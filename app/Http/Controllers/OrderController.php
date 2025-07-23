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
            ->orderByDesc('created_at')
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

    public function reorder(Request $request, $orderId)
    {
        $order = Order::with('orderDetails.product.category')->findOrFail($orderId);

        $items = [];

        foreach ($order->orderDetails as $detail) {
            $product = $detail->product;

            if (!$product) continue;

            $items[] = [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category->name ?? 'N/A',
                'quantity' => $detail->qty,
                'stockQty' => $product->qty,
                'image' => asset('storage/' . $product->image),
                'price' => (int) $product->sale_price,
            ];
        }

        // Return JSON instead of a redirect or view
        return response()->json($items);
    }
}