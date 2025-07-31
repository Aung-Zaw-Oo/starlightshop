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
                <img class="customer-image" src="{{ asset('storage/' . ($customer->image ?? 'uploads/default-avatar.png')) }}" alt="customer-image">
                <div class="name">{{ $customer->name }}</div>
        </td>
        <td>
            {{ $customer->phone }}
        </td>
        <td>
            {{ $customer->credential->email ?? 'N/A' }}
        </td>
        <td>
            {{ $customer->item_bought }}
        </td>
        <td>
            ${{ number_format($customer->money_spent, 2) }}
        </td>
        <td>
            {{ $customer->last_login ? \Carbon\Carbon::parse($customer->last_login)->diffForHumans() : 'Never' }}
        </td>

    </tr>
    @endforeach
    <tr>
        <td colspan="9" class="" style="padding: 10px; font-weight: bold; text-align: center;">
            Showing {{ $customers->count() }} of {{ $customers->total() }} customers.
        </td>
    </tr>

    @if ($customers->hasPages())
        <tr>
            <td colspan="9" style="text-align:center; padding: 0; margin: 0; border: none">
                <div class="pagination-wrapper">
                    {{ $customers->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
                </div>
            </td>
        </tr>
    @endif
@endif
