@extends('customer.layout.layout')

@section('title', 'Payment Success')

<link rel="stylesheet" href="{{ asset('css/customer/thanks.css') }}">

@section('content')
    <div class="thank-box">
        <h2>Thank For Your Purchase</h2>
        <div class="message">
            <div class="icon">
                <img src="{{ asset('storage/uploads/thumb-up.png') }}">
            </div>
            <p>Your payment was successful.</p>
            <p>Thank you for your payment.</p>
            <p>We will be in contact with more details shortly.</p>
            <a href="{{ route('customer.product_list') }}" class="btn primary">OK</a>
        </div>
    </div>
@endsection

@push('scripts')

@endpush