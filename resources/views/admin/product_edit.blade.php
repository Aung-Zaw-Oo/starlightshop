@extends('admin.layout')

@section('title', 'Edit Employee')

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
        <span>Product</span>
        <span> > </span>
        <span>Edit</span>
    </div>
</div>

<div class="form-container">
    <div class="form-wrapper">
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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

            <div class="profile-section">
                <div class="profile-image">
                    @if ($product->image)
                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                    @else
                        <i class="fa-solid fa-box" id="profile-icon"></i>
                        <img id="image-preview" style="display: none;" alt="Product Preview">
                    @endif
                </div>
                <div class="file-upload-wrapper">
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                        <label for="image" class="file-input-label" id="file-label">
                            <span>Choose File</span>
                            <span style="margin-left: auto; color: #a0aec0;">{{ $product->image ? 'Current image loaded' : 'No file chosen' }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="name">Name</label>
                </div>
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="Product Name" required value="{{ $product->name }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="category_id">Category</label>
                </div>
                <div class="form-group">
                    <select name="category_id" id="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="sale_price">Sale Price ($)</label>
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" name="sale_price" id="sale_price" placeholder="0.00" required value="{{ $product->sale_price }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="purchase_price">Purchase Price ($)</label>
                </div>
                <div class="form-group">
                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" placeholder="0.00" required value="{{ $product->purchase_price }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="qty">Quantity</label>
                </div>
                <div class="form-group">
                    <input type="number" name="qty" id="qty" placeholder="0" required value="{{ $product->qty }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="width: 150px; flex: none;">
                    <label for="description">Description</label>
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" placeholder="Enter description..." required>{{ $product->description }}</textarea>
                </div>
            </div>

            <div class="btn-group-wrapper">
                <div class="left-group">
                    <button type="button" class="btn btn-danger" onclick="showDeleteModal()">Delete</button>
                </div>
                <div class="right-group">
                    <a href="{{ route('admin.product') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<!-- Custom Delete Confirmation Modal -->
<div id="delete-modal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button type="button" class="modal-close" onclick="hideDeleteModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this Product Record?</p>
            <p style="color: #a0aec0; font-size: 14px; margin-top: 12px;">This action cannot be undone and will permanently remove all associated data.</p>
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
            preview.style.display = 'none';
            if (icon) icon.style.display = 'block';
            label.innerHTML = '<span>Choose File</span><span style="margin-left: auto; color: #a0aec0;">No file chosen</span>';
        }
    }

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