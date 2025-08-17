<?php

namespace App\Http\Controllers;

use Stripe\Refund;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Mail\OrderCancelled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer.credential', 'orderDetails.product'])
            ->where('order_status', 'pending')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends(request()->all());

        // Only load order details for shown orders
        $orderIds = $orders->pluck('id');
        $orderdetails = OrderDetail::whereIn('order_id', $orderIds)
            ->with(['product', 'order.customer.credential'])
            ->get();

        return view('admin.order.order', compact('orders', 'orderdetails'));
    }

    public function edit($id)
    {
        $order = Order::with(['customer.credential', 'orderDetails.product'])
            ->findOrFail($id);

        return view('admin.order.order_edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->order_status;
        $order->update($request->all());

        // If the order was not cancelled before but now is cancelled
        if ($oldStatus !== 'cancelled' && $order->order_status === 'cancelled') {
            // 1. Restock products
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    $product->qty += $detail->qty;
                    $product->save();
                }
            }

            // 2. Process Stripe refund
            if ($order->stripe_payment_id) {
                Stripe::setApiKey(config('services.stripe.secret'));
                Refund::create([
                    'payment_intent' => $order->stripe_payment_id,
                ]);
            }

            // 3. Send cancellation email
            Mail::to($order->customer->credential->email)
                ->send(new OrderCancelled($order));
        }

        return redirect()->route('admin.order')->with('success', 'Order updated successfully.');
    }



    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        $fromDate = $request->get('from-date');
        $toDate = $request->get('to-date');

        $ordersQuery = Order::with(['customer.credential', 'orderDetails.product'])
            ->when($query, function ($q) use ($query) {
                $keywords = preg_split('/\s+/', trim($query));

                $q->where(function ($subQuery) use ($keywords, $query) {

                    // Customer name matches all keywords
                    $subQuery->whereHas('customer', function ($q1) use ($keywords) {
                        foreach ($keywords as $word) {
                            $q1->where('name', 'like', "%{$word}%");
                        }
                    })

                    // Customer email matches query
                    ->orWhereHas('customer.credential', function ($q2) use ($query) {
                        $q2->where('email', 'like', "%{$query}%");
                    })

                    // Product name matches all keywords
                    ->orWhereHas('orderDetails', function ($q3) use ($keywords) {
                        foreach ($keywords as $word) {
                            $q3->whereHas('product', function ($q4) use ($word) {
                                $q4->where('name', 'like', "%{$word}%");
                            });
                        }
                    })

                    // Customer phone matches query
                    ->orWhereHas('customer', function ($q5) use ($query) {
                        $q5->where('phone', 'like', "%{$query}%");
                    })

                    // Status
                    ->orWhere('order_status', 'like', "%{$query}%")

                    // Quantity
                    ->orWhere('qty', 'like', "%{$query}%")

                    // Total price
                    ->orWhere('total_price', 'like', "%{$query}%");                    
                });
            })
            ->when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($q) => $q->whereDate('created_at', '<=', $toDate))
            ->orderByDesc('created_at');

        $orders = $ordersQuery->where('order_status', 'pending')->paginate(10)->appends([
            'query' => $query,
            'from-date' => $fromDate,
            'to-date' => $toDate,
        ]);

        $orderIds = $orders->pluck('id');
        $orderdetails = OrderDetail::whereIn('order_id', $orderIds)
            ->with(['product', 'order.customer.credential'])
            ->get();

        $device = $request->header('X-Device', 'desktop');

        if ($device === 'mobile') {
            return view('admin.order.partials.order-card', compact('orders', 'orderdetails'))->render();
        }

        return view('admin.order.partials.order-table', compact('orders', 'orderdetails'))->render();

    }
}
