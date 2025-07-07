<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderdetails = OrderDetail::with(['order.customer', 'product'])->paginate(5);
        $orders = Order::with(['customer.credential', 'orderDetails.product'])->paginate(5);
        return view('admin.order', compact('orderdetails', 'orders'));
    }

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $orders = Order::with(['customer.credential', 'orderDetails.product', 'orderDetails.order'])
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->whereHas('customer', function ($customerQuery) use ($query) {
                        $customerQuery->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('orderDetails.product', function ($productQuery) use ($query) {
                        $productQuery->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('orderDetails.order', function ($orderQuery) use ($query) {
                        $orderQuery->where('qty', 'like', "%$query%");
                    })
                    ->orWhereHas('orderDetails.order', function ($orderQuery) use ($query) {
                        $orderQuery->where('order_status', 'like', "%$query%");
                    })
                    ->orWhereHas('customer.credential', function ($credentialQuery) use ($query) {
                        $credentialQuery->where('email', 'like', "%$query%");
                    });
                });
            })
            ->when($fromDate, function ($q) use ($fromDate) {
                $q->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($q) use ($toDate) {
                $q->whereDate('created_at', '<=', $toDate);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Get order details for the paginated orders
        $orderIds = $orders->pluck('id');
        $orderdetails = OrderDetail::whereIn('order_id', $orderIds)
            ->with(['product', 'order.customer.credential'])
            ->get();

        $device = $request->header('X-Device');

        if ($device === 'mobile') {
            return view('admin.order.partials.order-cards', compact('orders', 'orderdetails'))->render();
        } else {
            return view('admin.order.partials.order-table', compact('orders', 'orderdetails'))->render();
        }
    }
}
