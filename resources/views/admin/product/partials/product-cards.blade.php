@if ($products->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No product found.
        </td>
    </tr>
@else
    @foreach ($products as $product)
        <div class="staff-card clickable-card" data-href="{{ route('admin.product.edit', $product->id) }}">
            <div class="card-header">
                <img class="avatar" src="{{ asset('storage/' . ($product->image ?? 'uploads/default-item.png')) }}" alt="Avatar">
                <div class="name">{{ $product->name }}</div>
            </div>
            <div class="card-body">
                <div><strong>Category:</strong> {{ $product->category->name }}</div>
                <div><strong>Sale Price:</strong> ${{ $product->sale_price }}</div>
                <div><strong>purchase Price:</strong> ${{ $product->purchase_price }}</div>
                <div><strong>Qty:</strong> {{ $product->qty }}</div>
                <div><strong>Status:</strong> {{ $product->status }}</div>
                <div><strong>Last Updated:</strong> {{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->diffForHumans() : 'Never' }}</div>
            </div>
        </div>
    @endforeach
@endif
