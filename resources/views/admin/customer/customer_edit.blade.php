@extends('admin.layout.layout')

@section('title', 'Edit Customer')

@section('content')

<!-- Breadcrumb -->
<div class="customer-breadcrumb">
    <div class="customer-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Customer</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Edit</span>
    </div>
</div>


<div class="customer-edit-form-container">
    <div class="customer-edit-form-wrapper">
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

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="name">Name</label>
                </div>
                <div class="customer-edit-form-group">
                    <input type="text" name="name" id="name" placeholder="Name" required value="{{ $customer->name }}">
                </div>
            </div>

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="dob_day">D.O.B</label>
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

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="email">Email</label>
                </div>
                <div class="customer-edit-form-group">
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required value="{{ $customer->credential->email }}">
                </div>
            </div>

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="address">Address</label>
                </div>
                <div class="customer-edit-form-group">
                    <textarea name="address" id="address" placeholder="Enter address......" required>{{ $customer->address }}</textarea>
                </div>
            </div>

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="phone">Phone</label>
                </div>
                <div class="customer-edit-form-group">
                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" required value="{{ $customer->phone }}">
                </div>
            </div>

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="status">Status</label>
                </div>
                <div class="customer-edit-form-group">
                    <select name="status" id="status" required>
                        <option value="Active" {{ $customer->status === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $customer->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="password">Password</label>
                </div>
                <div class="customer-edit-form-group">
                    <input type="password" name="password" id="password" placeholder="Enter new password (leave blank to keep current)">
                </div>
            </div>

            <div class="customer-edit-form-row">
                <div class="customer-edit-form-group" style="width: 150px; flex: none;">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="customer-edit-form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password">
                </div>
            </div>

            <input type="hidden" name="dob" id="dob" value="{{ $customer->dob }}">

            <div class="btn-group">
                <div class="btn-left">
                    <button type="button" class="btn danger" onclick="showDeleteModal()">Delete</button>
                </div>
                <div class="btn-right">
                    <a href="{{ route('admin.customer') }}" class="btn secondary">Cancel</a>
                    <button type="submit" class="btn primary">Update</button>
                </div>
            </div>
        </form>
        <form id="delete-form" action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST" style="display: none;">
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
</script>
@endpush
