@if ($orders->isEmpty())
    <tr>
        <td colspan="9" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No Order found.
        </td>
    </tr>
@else
    @foreach ($orders as $order)
    <tr class="clickable-row" data-href="{{ route('admin.order.edit', $order->id) }}">
        <td>
            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
        </td>

        <td>
            @if ($order->orderDetails->isNotEmpty())
                @php
                    $firstDetail = $order->orderDetails->first();
                    $product = $firstDetail->product;
                    $productImage = $product->image;
                @endphp

                <div>
                    <img class="avatar" src="{{ asset('storage/' . ($productImage ?? 'uploads/default-avatar.png')) }}" alt="Avatar">
                    {{ $product?->name ?? 'Unknown Product' }}
                </div>
            @else
                <div>No Product</div>
            @endif
        </td>

        <td>
            {{ $order->created_at ? $order->created_at->format('d-m-Y h:i A') : 'Never' }}
        </td>

        <td>{{ $order->total_price }}</td>

        <td>{{ $order->customer->name }}</td>

        <td>{{ $order->customer->credential->email }}</td>

        <td>{{ $order->qty }}</td>

        <td>{{ $order->customer->phone }}</td>

        <td>
            <span class="status {{ strtolower($order->order_status) }}">
                {{ ucfirst($order->order_status) }}
            </span>
        </td>
    </tr>
@endforeach

@endif
