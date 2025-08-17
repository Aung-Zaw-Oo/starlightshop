@extends('customer.layout.layout')

@section('title', 'Contact Us')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/customer/contact.css') }}">
@endpush

@section('content')
    <div class="contact-box">
        <div class="contact-upper">
            <div class="contact-left">
                <p class="title">Contact Us</p>
                <p>Email, call, or complete the form to learn how StarLight Store can solve your messaging problem.</p>
                <a href="mailto:starlight@shopping.com.mm">
                    <i class="fa-solid fa-envelopes-bulk"></i>
                    <span> starlight@shopping.com.mm</span>
                </a>  
                <a href="tel:+95948383383">
                    <i class="fa-solid fa-phone"></i> 
                    <span> +95 948 383 383</span>
                </a>
            </div>
            <div class="contact-right">
                <h2>Form</h2>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush