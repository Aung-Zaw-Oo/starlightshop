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
    input[type="number"],
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

    /* Remove number input spinners in Chrome, Safari, Edge */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Remove number input spinners in Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
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
        <span>Product</span>
        <span> > </span>
        <span>Register</span>
    </div>
</div>

<div class="form-container">
    <div class="form-wrapper">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
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

            <!-- Image Upload -->
            <div class="profile-section">
                <div class="profile-image">
                    <i class="fa-solid fa-box" id="profile-icon"></i>
                    <img id="image-preview" style="display: none;" alt="Image Preview">
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

            <!-- Product Name -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="name">Name</label>
                </div>
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="Product Name" value="{{ old('name') }}">
                </div>
            </div>

            <!-- Category -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="category_id">Category</label>
                </div>
                <div class="form-group">
                    <select name="category_id" id="category_id">
                        <option value="" disabled selected>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Sale Price -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="sale_price">Sale Price ($)</label>
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" name="sale_price" id="sale_price" placeholder="0.00" value="{{ old('sale_price') }}">
                </div>
            </div>

            <!-- Purchase Price -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="purchase_price">Purchase Price ($)</label>
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" placeholder="0.00" value="{{ old('purchase_price') }}">
                </div>
            </div>

            <!-- Quantity -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="qty">Quantity</label>
                </div>
                <div class="form-group">
                    <input type="number" name="qty" id="qty" placeholder="0" value="{{ old('qty') }}">
                </div>
            </div>

            <!-- Description -->
            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="description">Description</label>
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" placeholder="Enter description...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="btn-group">
                <a href="{{ route('admin.product') }}" class="btn btn-secondary">Cancel</a>
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
    </script>
@endpush