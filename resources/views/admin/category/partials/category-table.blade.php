@if ($categories->isEmpty())
    <tr>
        <td colspan="4" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No category found.
        </td>
    </tr>
@else
    @foreach ($categories as $category)
    <tr class="clickable-row" data-href="{{ route('admin.category.edit', $category->id) }}">
        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
        <td>
            <img class="product-image" src="{{ asset('storage/' . ($category->image ?? 'uploads/default-item.png')) }}" alt="product-image">
            {{ $category->name }}
        </td>
        <td>
            @if ($category->status == 'active')
                <span class="status-{{ strtolower($category->status) }}">{{ ucfirst($category->status) }}</span>
            @else
                <span class="status-{{ strtolower($category->status) }}">{{ ucfirst($category->status) }}</span>
            @endif
        </td>
        <td>{{ $category->updated_at ? \Carbon\Carbon::parse($category->updated_at)->diffForHumans() : 'Never' }}</td>
    </tr>
@endforeach
    <tr>
        <td colspan="8" class="" style="padding: 10px; font-weight: bold; text-align: center;">
            Showing {{ $categories->count() }} of {{ $categories->total() }} categories.
        </td>
    </tr>

    @if ($categories->hasPages())
        <tr>
            <td colspan="8" style="text-align:center; padding: 0; margin: 0; border: none">
                <div class="pagination-wrapper">
                    {{ $categories->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
                </div>
            </td>
        </tr>
    @endif
@endif
