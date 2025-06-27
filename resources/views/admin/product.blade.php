@extends('admin.layout')

@section('title', 'Products')

@push('styles')
@endpush

@section('content')
    <div class="breadcrumb">
        <div class="left">
            <span><i class="fa-solid fa-house"></i> Home</span>
            <span> > </span>
            <span>Product</span>
        </div>
        <div class="center"></div>
        <div class="right">
            <button class="active">7D</button>
            <button>M</button>
        </div>
    </div>
    
    <div class="dashboard-header">
        <h1>Product</h1>
        <p>Content</p>
    </div>
@endsection