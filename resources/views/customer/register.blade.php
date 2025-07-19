@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/customer/register.css') }}">

@section('content')
    <div>
        <h2>CUSTOMER REGISTRATION</h2>
        <div class="form-container">
            <form action="{{ route('customer.registerProcess') }}" method="post">
                @csrf
                <div class="input-box">
                    <label for="name">Customer Name:</label>
                    <input type="text" name="name" id="name" placeholder="Enter Your Name">
                </div>
                <div class="input-box">
                    <label for="email">Customer Email:</label>
                    <input type="email" name="email" id="email" placeholder="Enter Your Email">
                </div>
                <div class="input-box">
                    <label for="address">Customer Address:</label>
                    <textarea name="address" id="address" placeholder="Enter Your Address"></textarea>
                </div>
                <div class="input-box">
                    <label for="phone">Customer Phone:</label>
                    <input type="tel" name="phone" id="phone" placeholder="Enter Your Phone Number">
                </div>
                <div class="input-box">
                    <label for="day">Customer DOB:</label>
                    <div class="dob-dmy">
                        <select name="day" id="day">
                            <option value="">DD</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}">{{ sprintf('%02d', $d) }}</option>
                            @endfor
                        </select>

                        <select name="month" id="month">
                            <option value="">MM</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}">{{ sprintf('%02d', $m) }}</option>
                            @endfor
                        </select>

                        <select name="year" id="year">
                            <option value="">YYYY</option>
                            @for ($y = date('Y'); $y >= 1950; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="input-box">
                    <label for="password">Customer Password:</label>
                    <input type="password" name="password" id="password" placeholder="Enter Your Password">
                </div>
                <div class="input-box">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Enter Your Password Again">
                </div>
                <div class="input-box">
                    <label for="image">Customer Image:</label>
                    <div class="custom-file-wrapper">
                        <label for="image" class="custom-file-label">Choose File</label>
                        <span id="file-chosen">No file chosen</span>
                        <input type="file" name="image" id="image" accept="image/*">
                    </div>
                </div>
                <div class="button-group">
                    <button type="submit" class="primary btn">Register</button>
                    <button type="reset" class="secondary btn">Cancel</button>
                </div>
                
                <a href="{{ route('customer.loginForm') }}">Already have an account? <span>Login Now.</span></a>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Custom File Input
        document.getElementById('image').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-chosen').textContent = fileName;
        });
    </script>
@endpush
