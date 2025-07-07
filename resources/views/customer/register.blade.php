@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
        :root {
            --text-8: #FCA311;
            --color-8: #E5E5E5;
            --color-3: #3a3a3a;
            --green: #8AC926;
        }

        .main-content div {
            padding: 1rem 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #282828;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            color: var(--color-8);
        }

        .input-box {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }

        .input-box label {
            width: 180px;
            font-weight: bold;
            font-size: 0.95rem;
            color: var(--color-8);
            flex-shrink: 0;
        }

        .input-box input[type="text"],
        .input-box input[type="email"],
        .input-box input[type="tel"],
        .input-box input[type="password"],
        .input-box input[type="number"],
        .input-box input[type="file"],
        .input-box textarea {
            flex: 1;
            background-color: var(--color-3);
            border: 1px solid #444;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 1rem;
            color: #fff;
            transition: border-color 0.3s ease;
        }

        .input-box textarea {
            resize: vertical;
            min-height: 80px;
        }

        .input-box input:focus,
        .input-box textarea:focus {
            border-color: var(--text-8);
            outline: none;
        }

        .dob-dmy {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            width: 100%;
        }

        .dob-dmy input {
            width: 100%;
        }

        .dob-dmy input:focus {
            border-color: var(--text-8);
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 0.9rem;
            background-color: var(--green);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #1d2a4d;
        }

        form a {
            display: block;
            text-align: center;
            margin-top: 1.2rem;
            text-decoration: none;
            font-size: 0.95rem;
            color: #aaa;
        }

        form a span {
            color: var(--green);
            font-weight: 500;
        }

        .dob-dmy select {
            width: 100%;
            padding: 0.65rem;
            background-color: var(--color-3);
            color: #fff;
            border: 1px solid #444;
            border-radius: 8px;
            font-size: 1rem;
            appearance: none;
        }

        .dob-dmy select:focus {
            border-color: var(--text-8);
            outline: none;
        }


        @media (max-width: 768px) {
            .input-box {
                flex-direction: column;
                align-items: flex-start;
            }

            .input-box label {
                width: 100%;
            }

            .input-box input[type="text"],
            .input-box input[type="email"],
            .input-box input[type="tel"],
            .input-box input[type="password"],
            .input-box input[type="number"],
            .input-box input[type="file"],
            .input-box textarea {
                width: 100%;
            }

            .dob-dmy {
                grid-template-columns: 1fr;
            }

            form {
                padding: 1.5rem;
            }
        }

        /* Custom File Input */
        .custom-file-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            background-color: var(--color-3);
            border-radius: 8px;
            padding: 0.5rem;
            color: #fff;
            transition: border-color 0.3s ease;
            width: 100%;
        }

        .custom-file-wrapper input[type="file"] {
            opacity: 0;
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .custom-file-label {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background-color: #444;
            color: #fff;
            border-radius: 6px;
            font-size: 0.95rem;
            cursor: pointer;
            z-index: 1;
            white-space: nowrap;
        }

        #file-chosen {
            font-size: 0.9rem;
            color: #ccc;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@section('content')
    <div>
        <h2 style="text-align:center;">CUSTOMER REGESTRATION</h2>
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
            <button type="submit">Register</button>
            <a href="{{ route('customer.loginForm') }}">Already have an account? <span style="color: var(--green);">Login Now.</span></a>
        </form>
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
