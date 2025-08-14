@if ($products->isEmpty())
    <tr>
        <td colspan="8" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No product found.
        </td>
    </tr>
@else
    @foreach ($products as $product)
        <tr class="clickable-row" data-href="{{ route('admin.product.edit', $product->id) }}">
            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
            <td>
                <img class="product-image" src="{{ asset('storage/' . ($product->image ?? 'uploads/default-item.png')) }}" alt="product-image">
                <span>{{ $product->name }}</span>
            </td>
            <td>{{ $product->category->name }}</td>
            <td>${{ $product->sale_price }}</td>
            <td>${{ $product->purchase_price }}</td>
            <td>{{ $product->qty }}</td>
            <td>
                <span> 
                    @if ($product->qty > 0 && $product->status == 'Active')
                        <span class="status-{{ strtolower($product->status) }}">Available</span>
                    @else
                        <span class="status-inactive">Out of Stock</span>
                    @endif 
                </span>
            </td>
            <td>{{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->diffForHumans() : 'Never' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="8" class="" style="padding: 10px; font-weight: bold; text-align: center;">
            Showing {{ $products->count() }} of {{ $products->total() }} products.
        </td>
    </tr>

    @if ($products->hasPages())
        <tr>
            <td colspan="8" style="text-align:center; padding: 0; margin: 0; border: none">
                <div class="pagination-wrapper">
                    {{ $products->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
                </div>
            </td>
        </tr>
    @endif
@endif
