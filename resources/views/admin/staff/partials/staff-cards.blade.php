@if ($staff->isEmpty())
    <tr>
        <td colspan="6" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No staff found.
        </td>
    </tr>
@else
    @foreach ($staff as $member)
        <div class="staff-card clickable-card" data-href="{{ route('admin.staff.edit', $member->id) }}">
            <div class="card-header">
                <img class="avatar" src="{{ asset('storage/' . ($member->image ?? 'uploads/default-avatar.png')) }}" alt="Avatar">
                <div class="name">{{ $member->first_name }} {{ $member->last_name }}</div>
            </div>
            <div class="card-body">
                <div><strong>Role:</strong> {{ $member->role->name }}</div>
                <div><strong>Email:</strong> {{ $member->credential->email }}</div>
                <div><strong>Status:</strong> {{ $member->status }}</div>
                <div><strong>Last Login:</strong> {{ $member->last_login ? \Carbon\Carbon::parse($member->last_login)->diffForHumans() : 'Never' }}</div>
            </div>
        </div>
    @endforeach
@endif
