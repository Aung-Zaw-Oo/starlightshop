@if ($categories->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No category found.
        </td>
    </tr>
@else
    @foreach ($categories as $category)
        <div class="staff-card clickable-card" data-href="{{ route('admin.category.edit', $category->id) }}">
            <div class="card-header">
                <img class="avatar" src="{{ asset('storage/' . ($category->image ?? 'uploads/default-item.png')) }}" alt="Avatar">
                <div class="name">{{ $category->name }}</div>
            </div>
            <div class="card-body">
                <div><strong>Status:</strong> {{ $category->status }}</div>
                <div><strong>Last Updated:</strong> {{ $category->updated_at ? \Carbon\Carbon::parse($category->updated_at)->diffForHumans() : 'Never' }}</div>
            </div>
        </div>
    @endforeach
@endif
