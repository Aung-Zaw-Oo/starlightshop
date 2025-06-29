@if ($categories->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No category found.
        </td>
    </tr>
@else
    @foreach ($categories as $category)
    <tr class="clickable-row" data-href="{{ route('admin.category.edit', $category->id) }}">
        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
        <td>
            <img class="avatar" src="{{ asset('storage/' . ($category->image ?? 'uploads/default-item.png')) }}" alt="Avatar">
            {{ $category->name }}
        </td>
        <td><span class="status {{ strtolower($category->status) }}">{{ $category->status }}</span></td>
        <td>{{ $category->updated_at ? \Carbon\Carbon::parse($category->updated_at)->diffForHumans() : 'Never' }}</td>
    </tr>
@endforeach
@endif
