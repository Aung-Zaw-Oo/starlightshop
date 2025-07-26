@extends('admin.layout.layout')

@section('title', 'Edit Employee')

@section('content')
<!-- Breadcrumb -->
<div class="employee-edit-breadcrumb">
    <div class="employee-edit-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Employee</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Edit Employee</span>
    </div>
</div>

<div class="employee-edit-form-container">
    <div class="employee-edit-form-wrapper">
        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @error('image')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="profile-section">
                <div class="profile-image">
                    @if ($staff->image)
                        <img id="image-preview" src="{{ asset('storage/' . $staff->image) }}" alt="Profile Image">
                    @else
                        <i class="fa-solid fa-user" id="profile-icon"></i>
                        <img id="image-preview" style="display: none;" alt="Profile Preview">
                    @endif
                </div>
                <div class="file-upload-wrapper">
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                        <label for="image" class="file-input-label" id="file-label">
                            <span>Choose File</span>
                            <span style="margin-left: auto; color: #a0aec0;">{{ $staff->image ? 'Current image loaded' : 'No file chosen' }}</span>
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
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="first_name">Name</label>
                </div>
                <div class="employee-edit-form-group">
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" value="{{ $staff->first_name }}">
                </div>
                <div class="employee-edit-form-group">
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" value="{{ $staff->last_name }}">
                </div>
            </div>

            @error('email')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="dob_day">D.O.B</label>
                </div>
                <div class="date-group">
                    <select name="dob_day" id="dob_day">
                        <option value="">DD</option>
                        @for($i = 1; $i <= 31; $i++)
                            @php
                                $day = sprintf('%02d', $i);
                                $currentDay = $staff->dob ? date('d', strtotime($staff->dob)) : '';
                            @endphp
                            <option value="{{ $day }}" {{ $currentDay == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endfor
                    </select>
                    <select name="dob_month" id="dob_month">
                        <option value="">MM</option>
                        @for($i = 1; $i <= 12; $i++)
                            @php
                                $month = sprintf('%02d', $i);
                                $currentMonth = $staff->dob ? date('m', strtotime($staff->dob)) : '';
                            @endphp
                            <option value="{{ $month }}" {{ $currentMonth == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endfor
                    </select>
                    <select name="dob_year" id="dob_year">
                        <option value="">YYYY</option>
                        @for($i = date('Y'); $i >= 1950; $i--)
                            @php
                                $currentYear = $staff->dob ? date('Y', strtotime($staff->dob)) : '';
                            @endphp
                            <option value="{{ $i }}" {{ $currentYear == $i ? 'selected' : '' }}>{{ $i }}</option>
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
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="role_id">Position</label>
                </div>
                <div class="employee-edit-form-group">
                    <select name="role_id" id="role_id" {{ $currentUserRole === 'Staff' ? 'disabled' : '' }}>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $staff->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>

                    @if ($currentUserRole === 'Staff')
                        <!-- Keep the role value submitted via hidden input -->
                        <input type="hidden" name="role_id" value="{{ $staff->role_id }}">
                    @endif
                </div>
            </div>

            @error('email')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="email">Email</label>
                </div>
                <div class="employee-edit-form-group">
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" value="{{ $staff->credential->email }}">
                </div>
            </div>

            @error('address')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="address">Address</label>
                </div>
                <div class="employee-edit-form-group">
                    <textarea name="address" id="address" placeholder="Enter address......">{{ $staff->address }}</textarea>
                </div>
            </div>

            @error('phone')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="phone">Phone</label>
                </div>
                <div class="employee-edit-form-group">
                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" value="{{ $staff->phone }}">
                </div>
            </div>

            @error('status')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="status">Status</label>
                </div>
                <div class="employee-edit-form-group">
                    <select name="status" id="status">
                        <option value="Active" {{ $staff->status === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $staff->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            @error('password')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="password">Password</label>
                </div>
                <div class="employee-edit-form-group">
                    <input type="password" name="password" id="password" placeholder="Enter new password (leave blank to keep current)">
                </div>
            </div>

            @error('password_confirmation')
                <p class="alert alert-error">{{ $message }}</p>
            @enderror
            <div class="employee-edit-form-row">
                <div class="employee-edit-form-group" style="width: 150px; flex: none;">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="employee-edit-form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password">
                </div>
            </div>

            <!-- Hidden date field for backend -->
            <input type="hidden" name="dob" id="dob" value="{{ $staff->dob }}">

            @php
                $currentUserId = session('staff_id');
                $currentUserRole = session('role');
                $isSelf = $staff->id === $currentUserId;
            @endphp

            <div class="btn-group">
                <div class="left-group">
                    @if ($currentUserRole !== 'Staff' && !$isSelf)
                        <button type="button" class="btn danger" onclick="showDeleteModal()">Delete</button>
                    @elseif ($currentUserRole === 'Staff' && $isSelf)
                        {{-- Staff cannot delete self --}}
                        <button type="button" class="btn danger" disabled title="You cannot delete yourself.">Delete</button>
                    @else
                        <!-- NA -->
                    @endif
                </div>
                <div class="right-group">
                    <a href="{{ route('admin.employee') }}" class="btn secondary">Cancel</a>
                    
                    @if ($currentUserRole === 'Staff' && !$isSelf)
                        {{-- Staff cannot edit others --}}
                        <button type="submit" class="btn primary" disabled title="You cannot edit other users.">Update</button>
                    @else
                        <button type="submit" class="btn primary">Update</button>
                    @endif
                </div>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form id="delete-form" action="{{ route('admin.staff.destroy', $staff->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
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
                if (icon) icon.style.display = 'none';
            };
            reader.readAsDataURL(file);
            
            // Update file label
            const fileName = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
            label.innerHTML = `<span>Choose File</span><span style="margin-left: auto; color: #ffffff;">${fileName}</span>`;
        } else {
            // Reset to original state
            @if ($staff->image)
                preview.src = "{{ asset('storage/' . $staff->image) }}";
                preview.style.display = 'block';
            @else
                preview.style.display = 'none';
                if (icon) icon.style.display = 'block';
            @endif
            label.innerHTML = '<span>Choose File</span><span style="margin-left: auto; color: #a0aec0;">{{ $staff->image ? "Current image loaded" : "No file chosen" }}</span>';
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