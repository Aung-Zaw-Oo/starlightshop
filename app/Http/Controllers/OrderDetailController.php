<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer.credential', 'orderDetails.product'])
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends(request()->all());

        // Only load order details for shown orders
        $orderIds = $orders->pluck('id');
        $orderdetails = OrderDetail::whereIn('order_id', $orderIds)
            ->with(['product', 'order.customer.credential'])
            ->get();

        return view('admin.order', compact('orders', 'orderdetails'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        $fromDate = $request->get('from-date');
        $toDate = $request->get('to-date');

        $ordersQuery = Order::with(['customer.credential', 'orderDetails.product'])
            ->when($query, function ($q) use ($query) {
                $keywords = preg_split('/\s+/', $query);

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
                    ->orWhereHas('orderDetails.product', function ($q3) use ($keywords) {
                        foreach ($keywords as $word) {
                            $q3->where('name', 'like', "%{$word}%");
                        }
                    })
                    // Order fields
                    ->orWhere('order_status', 'like', "%{$query}%")
                    ->orWhere('qty', 'like', "%{$query}%");
                });
            })
            ->when($fromDate, fn($q) => $q->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($q) => $q->whereDate('created_at', '<=', $toDate))
            ->orderByDesc('created_at');

        $orders = $ordersQuery->paginate(10)->appends([
            'query' => $query,
            'from-date' => $fromDate,
            'to-date' => $toDate,
        ]);

        $orderIds = $orders->pluck('id');
        $orderdetails = OrderDetail::whereIn('order_id', $orderIds)
            ->with(['product', 'order.customer.credential'])
            ->get();

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.order.partials.order-cards', compact('orders', 'orderdetails'))->render();
        }

        return view('admin.order.partials.order-table', compact('orders', 'orderdetails'))->render();
    }
}
