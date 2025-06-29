@extends('admin.layout')

@section('title', 'Edit Customer')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

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

    .breadcrumb-bar {
        background-color: #3a4352;
        padding: 20px 40px;
        border-bottom: 1px solid #4a5568;
    }

    .breadcrumb-left {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #a0aec0;
        font-size: 14px;
    }

    .breadcrumb-left span {
        color: #a0aec0;
    }

    .breadcrumb-left i {
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

    .btn-group-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .left-group,
    .right-group {
        display: flex;
        gap: 10px;
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

    /* Custom Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: #4a5568;
        border-radius: 12px;
        padding: 0;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        transform: scale(0.9);
        animation: scaleIn 0.3s ease forwards;
        overflow: hidden;
    }

    .modal-header {
        background-color: #3a4352;
        padding: 20px 24px;
        border-bottom: 1px solid #4a5568;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        color: #ffffff;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: #a0aec0;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: #ffffff;
    }

    .modal-body {
        padding: 24px;
        color: #e2e8f0;
        font-size: 16px;
        line-height: 1.5;
    }

    .modal-footer {
        padding: 20px 24px;
        background-color: #3a4352;
        border-top: 1px solid #4a5568;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .modal-footer .btn {
        min-width: 80px;
    }

    .modal-btn-cancel {
        background-color: #4a5568;
        color: #e2e8f0;
        border: 1px solid #4a5568;
    }

    .modal-btn-cancel:hover {
        background-color: #2d3748;
        color: #ffffff;
    }

    .modal-btn-delete {
        background-color: #e53e3e;
        color: #ffffff;
        border: 1px solid #e53e3e;
    }

    .modal-btn-delete:hover {
        background-color: #c53030;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
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

        .btn-group-wrapper {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .left-group,
        .right-group {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
        }

        .btn {
            width: 100%;
        }

        .modal-content {
            width: 95%;
            margin: 20px;
        }

        .modal-footer {
            flex-direction: column-reverse;
        }

        .modal-footer .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="breadcrumb-bar">
    <div class="breadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span> > </span>
        <span>Customer</span>
        <span> > </span>
        <span>Update</span>
    </div>
</div>

<div class="form-container">
    <div class="form-wrapper">
        <form action="{{ route('admin.customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
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

            <!-- Profile Image Section -->
            <div class="profile-section">
                <div class="profile-image">
                    @if ($customer->image)
                        <img id="image-preview" src="{{ asset('storage/' . $customer->image) }}" alt="Profile Image">
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
                            <span style="margin-left: auto; color: #a0aec0;">{{ $customer->image ? 'Current image loaded' : 'No file chosen' }}</span>
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
                    <input type="text" name="name" id="name" placeholder="Name" required value="{{ $customer->name }}">
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
                            @php $day = sprintf('%02d', $i); $currentDay = $customer->dob ? date('d', strtotime($customer->dob)) : ''; @endphp
                            <option value="{{ $day }}" {{ $currentDay == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endfor
                    </select>
                    <select name="dob_month" id="dob_month" required>
                        <option value="">MM</option>
                        @for($i = 1; $i <= 12; $i++)
                            @php $month = sprintf('%02d', $i); $currentMonth = $customer->dob ? date('m', strtotime($customer->dob)) : ''; @endphp
                            <option value="{{ $month }}" {{ $currentMonth == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endfor
                    </select>
                    <select name="dob_year" id="dob_year" required>
                        <option value="">YYYY</option>
                        @for($i = date('Y'); $i >= 1950; $i--)
                            @php $currentYear = $customer->dob ? date('Y', strtotime($customer->dob)) : ''; @endphp
                            <option value="{{ $i }}" {{ $currentYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Email Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="email">Email</label>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required value="{{ $customer->credential->email }}">
                </div>
            </div>

            <!-- Address Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="address">Address</label>
                </div>
                <div class="form-group">
                    <textarea name="address" id="address" placeholder="Enter address......" required>{{ $customer->address }}</textarea>
                </div>
            </div>

            <!-- Phone Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="phone">Phone</label>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" required value="{{ $customer->phone }}">
                </div>
            </div>

            <!-- Status Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="status">Status</label>
                </div>
                <div class="form-group">
                    <select name="status" id="status" required>
                        <option value="Active" {{ $customer->status === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $customer->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Password Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="password">Password</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Enter new password (leave blank to keep current)">
                </div>
            </div>

            <!-- Confirm Password Section -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password">
                </div>
            </div>

            <input type="hidden" name="dob" id="dob" value="{{ $customer->dob }}">

            <!-- Action Buttons -->
            <div class="btn-group-wrapper">
                <div class="left-group">
                    <button type="button" class="btn btn-danger" onclick="showDeleteModal()">Delete</button>
                </div>
                <div class="right-group">
                    <a href="{{ route('admin.customer') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <form id="delete-form" action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <div id="delete-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Delete</h3>
                <button type="button" class="modal-close" onclick="hideDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this Customer Record?</p>
                <p style="color: #a0aec0; font-size: 14px; margin-top: 12px;">
                    This action cannot be undone and will permanently remove all associated data.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn modal-btn-cancel" onclick="hideDeleteModal()">Cancel</button>
                <button type="button" class="btn modal-btn-delete" onclick="confirmDelete()">Delete</button>
            </div>
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
            const fileName = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
            label.innerHTML = `<span>Choose File</span><span style="margin-left: auto; color: #ffffff;">${fileName}</span>`;
        } else {
            @if ($customer->image)
                preview.src = "{{ asset('storage/' . $customer->image) }}";
                preview.style.display = 'block';
            @else
                preview.style.display = 'none';
                if (icon) icon.style.display = 'block';
            @endif
            label.innerHTML = '<span>Choose File</span><span style="margin-left: auto; color: #a0aec0;">{{ $customer->image ? "Current image loaded" : "No file chosen" }}</span>';
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const day = document.getElementById('dob_day').value;
        const month = document.getElementById('dob_month').value;
        const year = document.getElementById('dob_year').value;
        if (day && month && year) {
            document.getElementById('dob').value = `${year}-${month}-${day}`;
        }
    });

    // Modal Functions
    function showDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function hideDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    function confirmDelete() {
        document.getElementById('delete-form').submit();
    }

    // Close modal when clicking on overlay
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideDeleteModal();
        }
    });

    // Legacy function for backward compatibility
    function deleteStaff() {
        showDeleteModal();
    }
</script>
@endpush
