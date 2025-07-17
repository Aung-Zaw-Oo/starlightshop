@extends('admin.layout.layout')

@section('title', 'Edit Product')

@section('content')
<!-- Breadcrumb -->
<div class="product-breadcrumb">
    <div class="product-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Product</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Edit Product</span>
    </div>
</div>

<div class="product-edit-form-container">
    <div class="product-edit-form-wrapper">
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

            <div class="product-section">
                <div class="product-image">
                    @if ($product->image)
                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                    @else
                        <i class="fa-solid fa-box" id="product-icon"></i>
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

            <div class="product-edit-form-row">
                <div class="product-edit-form-group" style="width: 150px; flex: none;">
                    <label for="name">Name</label>
                </div>
                <div class="product-edit-form-group">
                    <input type="text" name="name" id="name" placeholder="Product Name" required value="{{ $product->name }}">
                </div>
            </div>

            <div class="product-edit-form-row">
                <div class="product-edit-form-group" style="width: 150px; flex: none;">
                    <label for="category_id">Category</label>
                </div>
                <div class="product-edit-form-group">
                    <select name="category_id" id="category_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="product-edit-form-row">
                <div class="product-edit-form-group" style="width: 150px; flex: none;">
                    <label for="sale_price">Sale Price ($)</label>
                </div>
                <div class="product-edit-form-group">
                    <input type="number" step="0.01" name="sale_price" id="sale_price" placeholder="0.00" required value="{{ $product->sale_price }}">
                </div>
            </div>

            <div class="product-edit-form-row">
                <div class="product-edit-form-group" style="width: 150px; flex: none;">
                    <label for="purchase_price">Purchase Price ($)</label>
                </div>
                <div class="product-edit-form-group">
                    <input type="number" step="0.01" name="purchase_price" id="purchase_price" placeholder="0.00" required value="{{ $product->purchase_price }}">
                </div>
            </div>

            <div class="product-edit-form-row">
                <div class="product-edit-form-group" style="width: 150px; flex: none;">
                    <label for="qty">Quantity</label>
                </div>
                <div class="product-edit-form-group">
                    <input type="number" name="qty" id="qty" placeholder="0" required value="{{ $product->qty }}">
                </div>
            </div>

            <div class="product-edit-form-row">
                <div class="product-edit-form-group" style="width: 150px; flex: none;">
                    <label for="description">Description</label>
                </div>
                <div class="product-edit-form-group">
                    <textarea name="description" id="description" placeholder="Enter description..." required>{{ $product->description }}</textarea>
                </div>
            </div>

            <div class="btn-group">
                <div class="left-group">
                    <button type="button" class="btn danger" onclick="showDeleteModal()">Delete</button>
                </div>
                <div class="right-group">
                    <a href="{{ route('admin.product') }}" class="btn secondary">Cancel</a>
                    <button type="submit" class="btn primary">Update</button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
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
        const icon = document.getElementById('product-icon');
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
</script>
@endpush