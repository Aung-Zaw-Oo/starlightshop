@if ($orders->isEmpty())
    <div class="no-orders-message" style="padding: 20px; font-style: italic; color: gray; text-align: center;">
        No orders found.
    </div>
@else
    <div class="card-container">
        @foreach ($orders as $order)
             @php
                    $firstDetail = $order->orderDetails->first();
                    $product = $firstDetail->product;
                    $productImage = $product->image;
                @endphp

            <div class="order-card clickable-card" data-href="{{ route('admin.order.edit', $order->id) }}">
                <div class="card-header">
                    <img class="avatar"
                         src="{{ asset('storage/' . ($productImage ?? 'uploads/default-item.png')) }}"
                         alt="Avatar">
                    <div class="name">{{ $product->name ?? 'Unknown Product' }}</div>
                </div>
                <div class="card-body">
                    <div>
                        <strong>Status:</strong> 
                        <span class="status {{ strtolower($order->order_status) }}">
                        {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                    <div><strong>Customer:</strong> {{ $order->customer->name }}</div>
                    <div><strong>Ordered At:</strong> {{ $order->created_at ? $order->created_at->format('d-m-Y h:i A') : 'Never' }}</div>
                    <div><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if ($orders->hasPages())
    <tr>
        <td colspan="9">
            <div class="pagination-wrapper">
                {{ $orders->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        </td>
    </tr>
@endif
