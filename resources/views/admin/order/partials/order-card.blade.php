@if ($orders->isEmpty())
    <div class="no-orders-message" style="padding: 20px; font-style: italic; color: gray; text-align: center;">
        No orders found.
    </div>
@else
    @foreach ($orders as $order)
        @php
            $firstDetail = $order->orderDetails->first();
            $product = $firstDetail ? $firstDetail->product : null;
            $productImage = $product ? $product->image : null;
        @endphp

        <div class="order-card clickable-card" data-href="{{ route('admin.order.edit', $order->id) }}">
            <div class="card-header">
                <img src="{{ asset('storage/' . ($productImage ?? 'uploads/default-item.png')) }}" alt="Product Image"
                        onerror="this.src='{{ asset('storage/uploads/default-item.png') }}'">
                <div class="name">
                    {{ $product->name ?? 'Unknown Product' }}
                </div>
            </div>
            <div class="card-body">
                <div class="status-row">
                    <strong>Status:</strong> 
                    <span class="status-{{ strtolower($order->order_status) }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                <div class="info-row">
                    <strong>Customer:</strong> {{ $order->customer->name ?? 'Unknown Customer' }}
                </div>
                <div class="info-row">
                    <strong>Ordered At:</strong> 
                    {{ $order->created_at ? $order->created_at->format('m-d-Y h:i A') : 'Never' }}
                </div>
                <div class="info-row">
                    <strong>Total:</strong> ${{ number_format($order->total_price, 2) }}
                </div>
                @if ($order->orderDetails->count() != 0)
                    <div class="info-row">
                        <strong>Items:</strong> {{ $order->orderDetails->count() }} Products
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <div class="card-summary" style="padding: 10px; font-weight: bold; text-align: center;">
        Showing {{ $orders->count() }} of {{ $orders->total() }} orders.
    </div>
@endif

@if ($orders->hasPages())
    <div class="pagination-wrapper">
        {{ $orders->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
@endif
