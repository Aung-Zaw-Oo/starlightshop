@extends('admin.layout.layout')

@section('title', 'Add New Staff')

@section('content')
<!-- Breadcrumb -->
<div class="product-breadcrumb">
    <div class="product-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Employee</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Create Employee</span>
    </div>
</div>

<div class="employee-create-form-container">
    <div class="employee-create-form-wrapper">
        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @error('image')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
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

            @error('first_name')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            @error('last_name')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="first_name">Name</label>
                </div>
                <div class="employee-create-form-group">
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                </div>
                <div class="employee-create-form-group">
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                </div>
            </div>

            @error('dob')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="dob_day">D.O.B</label>
                </div>
                <div class="date-group">
                    <select name="dob_day" id="dob_day">
                        <option value="">DD</option>
                        @for($i = 1; $i <= 31; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ old('dob_day') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select>
                    <select name="dob_month" id="dob_month">
                        <option value="">MM</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ old('dob_month') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                        @endfor
                    </select>
                    <select name="dob_year" id="dob_year">
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

            @error('role_id')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="role_id">Position</label>
                </div>
                <div class="employee-create-form-group">
                    <select name="role_id" id="role_id">
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

            @error('email')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="email">Email</label>
                </div>
                <div class="employee-create-form-group">
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" value="{{ old('email') }}">
                </div>
            </div>

            @error('address')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="address">Address</label>
                </div>
                <div class="employee-create-form-group">
                    <textarea name="address" id="address" placeholder="Enter address......">{{ old('address') }}</textarea>
                </div>
            </div>

            @error('phone')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="phone">Phone</label>
                </div>
                <div class="employee-create-form-group">
                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" value="{{ old('phone') }}">
                </div>
            </div>

            @error('password')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="password">Password</label>
                </div>
                <div class="employee-create-form-group">
                    <input type="password" name="password" id="password">
                </div>
            </div>

            @error('password_confirmation')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-create-form-row">
                <div class="employee-create-form-group" style="width: 150px; flex: none;">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="employee-create-form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>
            </div>

            <!-- Hidden date field for backend -->
            <input type="hidden" name="dob" id="dob">

            <div class="btn-group">
                <div class="left-group">
                    <!-- NA -->
                </div>
                <div class="right-group">
                    <a href="{{ route('admin.employee') }}" class="btn secondary">Cancel</a>
                    <button type="submit" class="btn primary">Save</button>
                </div>
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