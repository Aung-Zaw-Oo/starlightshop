@if ($customers->isEmpty())
    <div class="no-customers-message" style="padding: 20px; font-style: italic; color: gray; text-align: center;">
        No customers found.
    </div>
@else
    @foreach ($customers as $customer)
        <div class="customer-card clickable-card" data-href="{{ route('admin.customer.edit', $customer->id) }}">
            <div class="card-header">
                <img src="{{ asset('storage/' . ($customer->image ?? 'uploads/default-avatar.png')) }}" alt="customer-image" onerror="this.src='{{ asset('storage/uploads/default-avatar.png') }}'">
                <div class="name">{{ $customer->name }}</div>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <strong>Phone:</strong> {{ $customer->phone }}
                </div>
                <div class="info-row">
                    <strong>Email:</strong> {{ $customer->credential->email ?? 'N/A' }}
                </div>
                <div class="info-row">
                    <strong>Items Bought:</strong> 
                    {{ $customer->item_bought }}
                </div>
                <div class="info-row">
                    <strong>Money Spent:</strong> 
                    ${{ number_format($customer->money_spent, 2) }}
                </div>
                <div class="info-row">
                    <strong>Last Login:</strong> {{ optional($customer->credential)->last_login ? \Carbon\Carbon::parse($customer->credential->last_login)->diffForHumans() : 'Never' }}
                </div>
            </div>
        </div>
    @endforeach

    
@endif

<div class="card-summary" style="padding: 10px; font-weight: bold; text-align: center;">
        Showing {{ $customers->count() }} of {{ $customers->total() }} customers.
</div>

@if ($customers->hasPages())
    <div class="pagination-wrapper">
        {{ $customers->appends(request()->all())->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
@endif
