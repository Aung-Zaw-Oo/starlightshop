@if ($customers->isEmpty())
    <tr>
        <td colspan="7" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No customer found.
        </td>
    </tr>
@else
    @foreach ($customers as $customer)
        <div class="staff-card clickable-card" data-href="{{ route('admin.customer.edit', $customer->id) }}">
            <div class="card-header">
                <img class="avatar" src="{{ asset('storage/' . ($customer->image ?? 'uploads/default-avatar.png')) }}" alt="Avatar">
                <div class="name">{{ $customer->name }}</div>
            </div>
            <div class="card-body">
                <div><strong>Phone:</strong> {{ $customer->phone }}</div>
                <div><strong>Email:</strong> {{ $customer->credential->email ?? 'N/A' }}</div>
                <div><strong>Items Bought:</strong> {{ $customer->item_bought }}</div>
                <div><strong>Money Spent:</strong> ${{ number_format($customer->money_spent, 2) }}</div>
                <div><strong>Last Login:</strong> {{ optional($customer->credential)->last_login ? \Carbon\Carbon::parse($customer->credential->last_login)->diffForHumans() : 'Never' }}</div>
            </div>
        </div>
    @endforeach
@endif
