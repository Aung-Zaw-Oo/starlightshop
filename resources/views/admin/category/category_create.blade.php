@extends('admin.layout.layout')

@section('title', 'Add New Category')

@section('content')
<!-- Breadcrumb -->
<div class="product-breadcrumb">
    <div class="product-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Category</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Create Category</span>
    </div>
</div>

<div class="category-create-form-container">
    <div class="category-create-form-wrapper">
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
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

            <div class="category-create-form-row">
                <div class="category-create-form-group" style="width: 150px; flex: none;">
                    <label for="name">Name</label>
                </div>
                <div class="category-create-form-group">
                    <input type="text" name="name" id="name" placeholder="Enter Category Name" required value="{{ old('name') }}">
                </div>
            </div>

            <div class="profile-section">
                <div class="profile-image">
                    <i class="fa-solid fa-box" id="profile-icon"></i>
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

            @php
                $currentUserRole = session('role');
            @endphp

            <!-- Action Buttons -->
            <div class="btn-group">
                <div class="left-group">
                    <a href="{{ route('admin.category') }}" class="btn secondary">Cancel</a>
                </div>
                <div class="right-group">
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
    </script>
@endpush