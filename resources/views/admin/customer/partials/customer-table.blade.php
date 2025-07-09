@if ($customers->isEmpty())
    <tr>
        <td colspan="7" class="text-center" style="padding: 20px; font-style: italic; color: gray;">
            No customer found.
        </td>
    </tr>
@else
    @foreach ($customers as $customer)
    <tr class="clickable-row" data-href="{{ route('admin.customer.edit', $customer->id) }}">
        <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
        <td>
                <img class="avatar" src="{{ asset('storage/' . ($customer->image ?? 'uploads/default-avatar.png')) }}" alt="Avatar">
                <div class="name">{{ $customer->name }}</div>
        </td>
        <td>{{ $customer->phone }}</td>
        <td>{{ $customer->credential->email ?? 'N/A' }}</td>
        <td>{{ $customer->item_bought }}</td>
        <td>${{ number_format($customer->money_spent, 2) }}</td>
        <td>{{ optional($customer->credential)->updated_at ? \Carbon\Carbon::parse($customer->credential->updated_at)->diffForHumans() : 'Never' }}</td>
    </tr>
    @endforeach
@endif
