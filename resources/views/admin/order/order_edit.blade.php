@extends('admin.layout.layout')

@section('title', 'Edit Order')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@section('content')

<!-- Breadcrumb -->
<div class="order-breadcrumb">
    <div class="order-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Order</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Edit Order</span>
    </div>
</div>

<div class="order-edit-form-container">
    <div class="order-edit-form-wrapper">
        <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="order-edit-form-group">
                <label>Customer</label>
                <input type="text" value="{{ $order->customer->name }}" disabled>
            </div>

            <div class="order-edit-form-group">
                <label>Order Date</label>
                <input type="text" value="{{ $order->order_date }}" disabled>
            </div>

            <div class="order-edit-form-group">
                <label>Total Price</label>
                <input type="text" value="$ {{ number_format($order->total_price, 2) }}" disabled>
            </div>

            <div class="order-edit-form-group">
                <label>Quantity</label>
                <input type="text" value="{{ $order->qty }}" disabled>
            </div>

            <div class="order-edit-form-group">
                <label>Payment Type</label>
                <input type="text" value="{{ $order->payment_type }}" readonly>
            </div>

            <div class="order-edit-form-group">
                <label>Order Status</label>
                <select name="order_status">
                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="order-edit-form-group">
                <label>Status</label>
                <select name="status">
                    <option value="active" {{ $order->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $order->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="btn-group">
                <div class="btn-left">
                    <a href="{{ route('admin.order') }}" class="btn secondary">Cancel</a>
                </div>

                <div class="btn-right">
                    <button type="submit" class="btn primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
