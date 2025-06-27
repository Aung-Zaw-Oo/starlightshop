@extends('admin.layout')

@section('title', 'Customers')

@push('styles')
@endpush

@section('content')
    <div class="breadcrumb">
        <div class="left">
            <span><i class="fa-solid fa-house"></i> Home</span>
            <span> > </span>
            <span>Customer</span>
        </div>
        <div class="center"></div>
        <div class="right">
            <button class="active">7D</button>
            <button>M</button>
        </div>
    </div>
    
    <div class="dashboard-header">
        <h1>Customer</h1>
        <p>Content</p>
    </div>
@endsection