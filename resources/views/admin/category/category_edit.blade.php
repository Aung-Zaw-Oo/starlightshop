@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
<div class="product-breadcrumb">
    <div class="product-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Category</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Edit Category</span>
    </div>
</div>

<div class="category-edit-form-container">
    <div class="category-edit-form-wrapper">
        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
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
                    @if ($category->image)
                        <img id="image-preview" src="{{ asset('storage/' . $category->image) }}" alt="Profile Image">
                    @else
                        <i class="fa-solid fa-box" id="profile-icon"></i>
                        <img id="image-preview" style="display: none;" alt="Profile Preview">
                    @endif
                </div>
                <div class="file-upload-wrapper">
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
                        <label for="image" class="file-input-label" id="file-label">
                            <span>Choose File</span>
                            <span style="margin-left: auto; color: #a0aec0;">{{ $category->image ? 'Current image loaded' : 'No file chosen' }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="category-edit-form-row">
                <div class="category-edit-form-group" style="width: 150px; flex: none;">
                    <label for="name">Name</label>
                </div>
                <div class="category-edit-form-group">
                    <input type="text" name="name" id="name" placeholder="Enter Category Name" required value="{{ $category->name }}">
                </div>
            </div>

            <!-- Status Section -->
            <div class="category-edit-form-row">
                <div class="category-edit-form-group" style="width: 150px; flex: none;">
                    <label for="status">Status</label>
                </div>
                <div class="category-edit-form-group">
                    <select name="status" id="status" required>
                        <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            @php
                $staff = session('staff');
                $currentUserId = session('staff_id');
                $currentUserRole = session('role');
                $isSelf = $staff->id === $currentUserId;
            @endphp

            <div class="btn-group">
                <div class="left-group">
                    @if ($currentUserRole !== 'Staff')
                        <button type="button" class="btn danger" onclick="showDeleteModal()">Delete</button>
                    @endif
                </div>
                <div class="right-group">
                    <a href="{{ route('admin.category') }}" class="btn secondary">Cancel</a>
                    
                    @if ($currentUserRole === 'Staff' && !$isSelf)
                        {{-- Staff cannot edit others --}}
                        <button type="submit" class="btn primary" disabled title="You cannot edit category.">Save</button>
                    @else
                        <button type="submit" class="btn primary">Save</button>
                    @endif
                </div>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form id="delete-form" action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display: none;">
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
            <p>Are you sure you want to delete this Category Record?</p>
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
            
            // Update file label
            const fileName = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
            label.innerHTML = `<span>Choose File</span><span style="margin-left: auto; color: #ffffff;">${fileName}</span>`;
        } else {
            // Reset to original state
            @if ($category->image)
                preview.src = "{{ asset('storage/' . $category->image) }}";
                preview.style.display = 'block';
            @else
                preview.style.display = 'none';
                if (icon) icon.style.display = 'block';
            @endif
            label.innerHTML = '<span>Choose File</span><span style="margin-left: auto; color: #a0aec0;">{{ $category->image ? "Current image loaded" : "No file chosen" }}</span>';
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