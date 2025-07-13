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
                <img class="employee-image" src="{{ asset('storage/' . ($member->image ?? 'uploads/default-avatar.png')) }}" alt="employee-image">
                <div class="name">{{ $member->first_name }} {{ $member->last_name }}</div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <strong>Role:</strong> 
                    {{ $member->role->name }}
                </div>
                <div class="info-row">
                    <strong>Email:</strong> {{ $member->credential->email }}
                </div>
                <div class="status-row">
                    <strong>Status:</strong> 
                    <span class="status-{{ strtolower($member->status) }}">{{ ucfirst($member->status) }}</span>
                </div>
                <div class="info-row">
                    <strong>Last Login:</strong> 
                    {{ $member->last_login ? \Carbon\Carbon::parse($member->last_login)->diffForHumans() : 'Never' }}
                </div>
            </div>
        </div>
    @endforeach

    <div class="card-summary" style="padding: 10px; font-weight: bold; text-align: center;">
        Showing {{ $staff->count() }} of {{ $staff->total() }} staff.
    </div>
@endif


@if ($staff->hasPages())
    <div class="pagination-wrapper">
        {{ $staff->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
@endif
