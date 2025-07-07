@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
        .thank-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: calc(100vh - 250px);
            padding: 2rem;
        }

        h2 {
            margin-bottom: 4rem;
        }
        
        .message {
            border: 1px solid var(--green);
            padding: 2rem;
            background-color: var(--bg-2);
            max-width: 350px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(15, 206, 31, 0.2);
        }

        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .icon i {
            border: 1px solid var(--green);
            padding: 1rem;
            border-radius: 50%;
            font-size: 4rem;
            background-color: var(--green);
        }

        .message p:first-of-type {
            text-align: center;
            margin-bottom: 2rem;
        }

        .message p:last-of-type {
            margin-bottom: 2rem;
        }

        .btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .btn-primary {
            background-color: var(--green);
            border-color: var(--green);
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #3e8e41;
        }
    </style>
@endpush

@section('content')
    <div class="thank-box">
        <h2>Thank For Your Purchase</h2>
        <div class="message">
            <div class="icon">
                <i class="fa-solid fa-thumbs-up"></i>
            </div>
            <p>Your payment was successful.</p>
            <p>Thank you for your payment.</p>
            <p>We will be in contact with more details shortly.</p>
            <a href="{{ route('customer.product_list') }}" class="btn btn-primary">OK</a>
        </div>
    </div>
@endsection

@push('scripts')

@endpush