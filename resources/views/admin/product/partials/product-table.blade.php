@if ($products->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No product found.
        </td>
    </tr>
@else
    @foreach ($products as $product)
    <tr class="clickable-row" data-href="{{ route('admin.product.edit', $product->id) }}">
        <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
        <td>
            <img class="avatar" src="{{ asset('storage/' . ($product->image ?? 'uploads/default-item.png')) }}" alt="Avatar">
        </td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->category->name }}</td>
        <td>${{ $product->sale_price }}</td>
        <td>${{ $product->purchase_price }}</td>
        <td>{{ $product->qty }}</td>
        <td>
            <span class="status {{ strtolower($product->status) }}"> 
                @if ($product->qty > 0 && $product->status == 'active')
                    Available
                @else
                    Out of Stock
                @endif 
            </span>
        </td>
        <td>{{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->diffForHumans() : 'Never' }}</td>
    </tr>
@endforeach
@endif
