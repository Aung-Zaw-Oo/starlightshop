@if ($staff->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No staff found.
        </td>
    </tr>
@else
    @foreach ($staff as $member)
    <tr class="clickable-row" data-href="{{ route('admin.staff.edit', $member->id) }}">
        <td>
            <img class="avatar" src="{{ asset('storage/' . ($member->image ?? 'uploads/default-avatar.png')) }}" alt="Avatar">
        </td>
        <td>{{ $member->first_name }} {{ $member->last_name }}</td>
        <td>{{ $member->role->name }}</td>
        <td>{{ $member->credential->email }}</td>
        <td>
            @if ($member->status == 'active')
                <span class="status {{ strtolower($member->status) }}">{{ ucfirst($member->status) }}</span>
            @else
                <span class="status {{ strtolower($member->status) }}">{{ ucfirst($member->status) }}</span>
            @endif
        </td>
        <td>{{ $member->last_login ? \Carbon\Carbon::parse($member->last_login)->diffForHumans() : 'Never' }}</td>
    </tr>
@endforeach
@endif
