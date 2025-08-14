@if ($products->isEmpty())
    <div class="no-products-message" style="padding: 20px; font-style: italic; color: gray; text-align: center;">
        No products found.
    </div>
@else
    @foreach ($products as $product)
        <div class="product-card clickable-card" data-href="{{ route('admin.product.edit', $product->id) }}">
            <div class="card-header">
                <img class="product-image" src="{{ asset('storage/' . ($product->image ?? 'uploads/default-item.png')) }}" alt="product-image">
                <div class="name">{{ Illuminate\Support\Str::limit($product->name, 30) }}</div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <strong>Category:</strong> 
                    {{ $product->category->name }}
                </div>
                <div class="info-row">
                    <strong>Sale Price:</strong> 
                    ${{ $product->sale_price }}
                </div>
                <div class="info-row">
                    <strong>purchase Price:</strong> 
                    ${{ $product->purchase_price }}
                </div>
                <div class="info-row">
                    <strong>Qty:</strong> 
                    {{ $product->qty }}
                </div>
                <div class="status-row">
                    <strong>Status:</strong> 
                    <span>
                        @if ($product->qty > 0 && $product->status == 'Active')
                            <span class="status-{{ strtolower($product->status) }}">
                                Available
                            </span>
                        @else
                        <span class="status-inactive">
                            Out of Stock
                        </span>
                        @endif 
                    </span>
                </div>
                <div class="info-row">
                    <strong>Last Updated:</strong> 
                    {{ $product->updated_at ? \Carbon\Carbon::parse($product->updated_at)->diffForHumans() : 'Never' }}
                </div>
            </div>
        </div>
    @endforeach
    
    <div class="card-summary" style="padding: 10px; font-weight: bold; text-align: center;">
        Showing {{ $products->count() }} of {{ $products->total() }} products.
    </div>
@endif

@if ($products->hasPages())
    <div class="pagination-wrapper">
        {{ $products->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
@endif
