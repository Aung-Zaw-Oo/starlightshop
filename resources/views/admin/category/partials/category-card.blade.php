@if ($categories->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No category found.
        </td>
    </tr>
@else
    @foreach ($categories as $category)
        <div class="category-card clickable-card" data-href="{{ route('admin.category.edit', $category->id) }}">
            <div class="card-header">
                <img class="category-image" src="{{ asset('storage/' . ($category->image ?? 'uploads/default-item.png')) }}" alt="category-image">
                <div class="name">{{ $category->name }}</div>
            </div>
            <div class="card-body">
                <div class="status-row">
                    <strong>Status:</strong>
                    <span class="status-{{ strtolower($category->status) }}">
                        {{ ucfirst($category->status) }}
                    </span>
                </div>
                <div class="info-row">
                    <strong>Last Updated:</strong> 
                    {{ $category->updated_at ? \Carbon\Carbon::parse($category->updated_at)->diffForHumans() : 'Never' }}
                </div>
            </div>
        </div>
    @endforeach

    <div class="card-summary" style="padding: 10px; font-weight: bold; text-align: center;">
        Showing {{ $categories->count() }} of {{ $categories->total() }} categories.
    </div>
@endif


@if ($categories->hasPages())
    <div class="pagination-wrapper">
        {{ $categories->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
@endif
