@extends('admin.layout.layout')

@section('title', 'Employees')

@section('content')
<!-- Notification Container -->
<div id="notification-container"></div>

<!-- Breadcrumb -->
<div class="employee-breadcrumb">
    <div class="employee-beadcrumb-left">
        <span><i class="fa-solid fa-house"></i> Home</span>
        <span>&nbsp;>&nbsp;</span>
        <span>Employees</span>
    </div>
    <div class="employee-beadcrumb-center">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" id="search" placeholder="search">
        </div> 
    </div>
    <div class="employee-beadcrumb-right">
         <a href="{{ route('admin.staff.create') }}" class="btn primary"><i class="fa-solid fa-plus"></i> Add</a>
    </div>
</div>

<div class="table-container desktop-only">
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Name</th>
                <th>Position</th>
                <th>Email</th>
                <th>Status</th>
                <th>Last Login</th>
            </tr>
        </thead>
        <tbody id="employee-table-body">
            @include('admin.employee.partials.employee-table', ['staff' => $staff])
        </tbody>
    </table>
</div>

<!-- Mobile Cards -->
<div class="card-list mobile-only" id="employee-card-list">
    @include('admin.employee.partials.employee-card', ['staff' => $staff])
</div>

<div class="pagination-wrapper">
    {{ $staff->onEachSide(1)->links('vendor.pagination.custom') }}
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    let typingTimer;
    const typingDelay = 500;

    function sendSearchRequest(page = 1) {
        const query = searchInput.value.trim();

        const params = new URLSearchParams({
            query: query,
            page: page
        });

        fetch(`{{ route('admin.staff.ajaxSearch') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-Device': window.innerWidth <= 768 ? 'mobile' : 'desktop'
            }
        })
        .then(response => response.text())
        .then(html => {
            if (window.innerWidth <= 768) {
                document.querySelector('#employee-card-list').innerHTML = html;
            } else {
                document.querySelector('#employee-table-body').innerHTML = html;
            }
            handleClickable();
        })
        .catch(error => console.error('Search error:', error));
    }

    // Search typing
    searchInput.addEventListener('keyup', () => {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => sendSearchRequest(), typingDelay);
    });

    // Pagination link clicks
    document.addEventListener('click', (e) => {
        if (e.target.matches('.pagination a')) {
            e.preventDefault();
            const pageUrl = new URL(e.target.href);
            const page = pageUrl.searchParams.get('page');
            sendSearchRequest(page);
        }
    });
});
</script>
@endpush