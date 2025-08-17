@extends('customer.layout.layout')

@section('title', 'Contact Us')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/customer/contact.css') }}">
@endpush

@section('content')
    <div class="contact-box">
        <div class="contact-upper">
            <div class="contact-left">
                <div>
                    <p class="title">Contact Us</p>
                    <p class="description">Email, call, or complete the form to learn how StarLight Store can solve your messaging problem.</p>
                </div>
                <div>
                    <a href="mailto:starlight@shopping.com.mm">
                        <i class="fa-solid fa-envelopes-bulk"></i>
                        <span> starlight@shopping.com.mm</span>
                    </a>
                    <a href="tel:+95948383383">
                        <i class="fa-solid fa-phone"></i> 
                        <span> +95 948 383 383</span>
                    </a>
                </div>
                <div>
                    <p class="sub-title">Customer Support</p>
                    <p class="description">Our support team is available around the clock to address any concerns or queries you may have.</p>
                </div>
                <div>
                    <p class="sub-title">Feedback and Suggestions</p>
                    <p class="description">We value your feedback and are continuously working to improve our services. Your input is crucial in shaping the future of StarLight Store.</p>
                </div>
                <div>
                    <p class="sub-title">Media Inquiries</p>
                    <p class="description">For media-related questions or press queries, please contact us at media@starlightstore.com</p>
                </div>
            </div>
            <div class="contact-right">
                <form action="{{ route('contact.send') }}" method="post">
                    @csrf
                    <p class="form-title">Get in Touch</p>
                    <p class="form-description">You can reach us anytime</p>
                    <div class="form-group">
                        <input type="text" id="first-name" name="first-name" placeholder="First name">
                        <input type="text" id="last-name" name="last-name" placeholder="Last name">
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <input type="tel" id="phone" name="phone" placeholder="Phone number">
                    </div>
                    <div class="form-group">
                        <textarea id="message" name="message" placeholder="Enter your message"></textarea>
                    </div>
                    <button type="submit" class="btn primary">Submit</button>
                    <small>By contacting us, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</small>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    @if(session('success'))
        showNotification("{{ session('success') }}", "success");
    @endif

    @if(session('error'))
        showNotification("{{ session('error') }}", "error");
    @endif
</script>
@endpush
