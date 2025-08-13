@if ($orders->isEmpty())
    <tr>
        <td colspan="9" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No orders found.
        </td>
    </tr>
@else
    @foreach ($orders as $index => $order)
        @php
            $firstDetail = $order->orderDetails->first();
            $product = $firstDetail?->product;
            $productImage = $product?->image ?? 'uploads/default-item.png';
        @endphp
        <tr class="clickable-row" data-href="{{ route('admin.order.edit', $order->id) }}">
            <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>

            <td>
                @if ($product)
                    <div>
                        <img class="product-image" src="{{ asset('storage/' . $productImage) }}" alt="product-image">
                        <span>{{ $product->name }}</span>
                    </div>
                @else
                    <div>No Product</div>
                @endif
            </td>

            <td>{{ $order->created_at?->format('m-d-Y h:i A') ?? 'Never' }}</td>
            <td>${{ number_format($order->total_price, 2) }}</td>
            <td>{{ $order->customer->name }}</td>
            <td>{{ $order->customer->credential->email }}</td>
            <td>{{ $order->qty }}</td>
            <td>{{ $order->customer->phone }}</td>
            <td>
                <span class="status-{{ strtolower($order->order_status) }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </td>
        </tr>
    @endforeach

    <tr>
        <td colspan="9" class="" style="padding: 10px; font-weight: bold; text-align: center;">
            Showing {{ $orders->count() }} of {{ $orders->total() }} orders.
        </td>
    </tr>

    @if ($orders->hasPages())
        <tr>
            <td colspan="9" style="text-align:center; padding: 0; margin: 0; border: none">
                <div class="pagination-wrapper">
                    {{ $orders->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
                </div>
            </td>
        </tr>
    @endif
@endif