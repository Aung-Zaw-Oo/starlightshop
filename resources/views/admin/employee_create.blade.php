@extends('admin.layout')

@section('title', 'Add New Staff')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/employee_create.css') }}">

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #3a4352;
        color: #ffffff;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        margin: 0;
        padding: 0;
    }

    .breadcrumb {
        background-color: #3a4352;
        padding: 20px 40px;
        border-bottom: 1px solid #4a5568;
    }

    .breadcrumb .left {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #a0aec0;
        font-size: 14px;
    }

    .breadcrumb .left span {
        color: #a0aec0;
    }

    .breadcrumb .left i {
        color: #ffffff;
    }

    .form-container {
        background-color: #3a4352;
        min-height: 100vh;
        padding: 40px;
        display: flex;
        justify-content: center;
    }

    .form-wrapper {
        background-color: #4a5568;
        border-radius: 12px;
        padding: 40px;
        width: 100%;
        max-width: 800px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .alert {
        margin-bottom: 24px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-error {
        background-color: #fed7d7;
        color: #9b2c2c;
        border: 1px solid #feb2b2;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 24px;
        align-items: flex-start;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        flex: 100%;
    }

    .profile-section {
        display: flex;
        gap: 30px;
        align-items: flex-start;
        margin-bottom: 32px;
    }

    .profile-image {
        width: 120px;
        height: 120px;
        background-color: #2d3748;
        border: 2px solid #4a5568;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .profile-image i {
        font-size: 48px;
        color: #a0aec0;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .file-upload-wrapper {
        flex: 1;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 14px;
        color: #e2e8f0;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    select,
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 14px 16px;
        background-color: #2d3748;
        border: 1px solid #4a5568;
        border-radius: 8px;
        color: #ffffff;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #3182ce;
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
    }

    input::placeholder {
        color: #718096;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
    }

    .date-group {
        display: flex;
        gap: 12px;
        flex: 1;
    }

    .date-group select {
        flex: 1;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        left: -9999px;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        background-color: #2d3748;
        border: 1px solid #4a5568;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #718096;
        font-size: 14px;
    }

    .file-input-label:hover {
        border-color: #3182ce;
    }

    .btn-group {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid #4a5568;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 100px;
    }

    .btn-secondary {
        background-color: #4a5568;
        color: #e2e8f0;
        border: 1px solid #4a5568;
    }

    .btn-secondary:hover {
        background-color: #2d3748;
        color: #ffffff;
    }

    .btn-primary {
        background-color: #3182ce;
        color: #ffffff;
    }

    .btn-primary:hover {
        background-color: #2c5282;
    }

    .btn-danger {
        background-color: #e53e3e;
        color: #ffffff;
        border: 1px solid #e53e3e;
    }

    .btn-danger:hover {
        background-color: #c53030;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }

        .form-wrapper {
            padding: 24px;
        }

        .profile-section {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .date-group {
            flex-direction: column;
        }

        .btn-group {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="breadcrumb">
    <div class="left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span> > </span>
        <span>Employee</span>
        <span> > </span>
        <span>Register</span>
    </div>
</div>

<div class="form-container">
    <div class="form-wrapper">
        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Image Section -->
            <div class="profile-section">
                <div class="profile-image">
                    <i class="fa-solid fa-user" id="profile-icon"></i>
                    <img id="image-preview" style="display: none;" alt="Profile Preview">
                </div>
                <div class="file-upload-wrapper">
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                        <label for="image" class="file-input-label" id="file-label">
                            <span>Choose File</span>
                            <span style="margin-left: auto; color: #a0aec0;">No file chosen</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Name Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="name-label">Name</label>
                </div>
                <div class="form-group">
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" required value="{{ old('first_name') }}">
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" required value="{{ old('last_name') }}">
                </div>
            </div>

            <!-- Date of Birth Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="dob-label">D.O.B</label>
                </div>
                <div class="date-group">
                    <select name="dob_day" id="dob_day" required>
                        <option value="">DD</option>
                        @for($i = 1; $i <= 31; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ old('dob_day') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select>
                    <select name="dob_month" id="dob_month" required>
                        <option value="">MM</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ old('dob_month') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select>
                    <select name="dob_year" id="dob_year" required>
                        <option value="">YYYY</option>
                        @for($i = date('Y'); $i >= 1950; $i--)
                            <option value="{{ $i }}" {{ old('dob_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            @php
                $currentUserRole = session('role');
            @endphp

            <!-- Position Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="role_id">Position</label>
                </div>
                <div class="form-group">
                    <select name="role_id" id="role_id" required>
                        <option value="">Choose...</option>
                        @foreach ($roles as $role)
                            @if ($currentUserRole !== 'Staff' || !in_array($role->name, ['Admin', 'Manager']))
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>


            <!-- Email Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="email">Email</label>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required value="{{ old('email') }}">
                </div>
            </div>

            <!-- Address Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="address">Address</label>
                </div>
                <div class="form-group">
                    <textarea name="address" id="address" placeholder="Enter address......" required>{{ old('address') }}</textarea>
                </div>
            </div>

            <!-- Phone Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="phone">Phone</label>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" required value="{{ old('phone') }}">
                </div>
            </div>

            <!-- Password Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="password">Password</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" required>
                </div>
            </div>

            <!-- Confirm Password Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
            </div>

            <!-- Hidden date field for backend compatibility -->
            <input type="hidden" name="dob" id="dob">

            <!-- Action Buttons -->
            <div class="btn-group">
                <a href="{{ route('admin.employee') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            const icon = document.getElementById('profile-icon');
            const label = document.getElementById('file-label');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    icon.style.display = 'none';
                };
                reader.readAsDataURL(file);
                
                // Update file label
                const fileName = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
                label.innerHTML = `<span>Choose File</span><span style="margin-left: auto; color: #ffffff;">${fileName}</span>`;
            } else {
                preview.style.display = 'none';
                icon.style.display = 'block';
                label.innerHTML = '<span>Choose File</span><span style="margin-left: auto; color: #a0aec0;">No file chosen</span>';
            }
        }

        // Combine date fields before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const day = document.getElementById('dob_day').value;
            const month = document.getElementById('dob_month').value;
            const year = document.getElementById('dob_year').value;
            
            if (day && month && year) {
                document.getElementById('dob').value = `${year}-${month}-${day}`;
            }
        });
    </script>
@endpush