@extends('customer.layout.layout')

@section('title', 'Order History')

<link rel="stylesheet" href="{{ asset('css/customer/order_history.css') }}">

@section('content')
    <div class="order-history-container">
        <h2>MY ORDER HISTORY</h2>
        <div class="order-history-table">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Qty</th>
                        <th>Card Number</th>
                        <th>Status</th>
                        <th>Reorder</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <td data-label="Order ID">{{ $order->id }}</td>
                                <td data-label="Product Name">{{ $detail->product->name ?? 'N/A' }}</td>
                                <td data-label="Image">
                                    @if(isset($detail->product) && $detail->product->image)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" loading="lazy">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td data-label="Date">{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                                <td data-label="Qty">{{ $detail->qty }}</td>
                                <td data-label="Card Number">{{ $order->payment_type }}</td>

                                <td data-label="Status" class="{{ strtolower($order->order_status) }}">
                                    @if ($order->order_status === 'pending')
                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="{{ strtolower($order->order_status) }}">
                                                <option value="pending" selected>Pending</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                        </form>
                                    @else
                                        <span class="{{ strtolower($order->order_status) }}">{{ ucfirst($order->order_status) }}</span>
                                    @endif
                                </td>

                                <td data-label="Reorder">
                                    <form action="{{ route('order.reorder', $detail->product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="reorder-btn" aria-label="Reorder {{ $detail->product->name ?? 'this item' }}">
                                            Reorder
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding: 2rem;">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrapper">
                {{ $orders->links() }}
            </div>
        </div>
    </div>    

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('.order-history-table');
                        
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.onerror = function() {
                    this.style.display = 'none';
                    this.parentNode.innerHTML = 'N/A';
                };
            });
        });
    </script>
@endpush