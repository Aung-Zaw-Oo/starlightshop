@extends('customer.layout.layout')

@section('title', 'Home')

<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

@push('styles')
    <style>
        th {
            font-weight: 900;
            background-color: #14213D;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #E5E5E5;
        }

        .order-history-table {
            transition: box-shadow 0.3s ease;
        }

        .order-history-container h2 {
            text-align: center;
            letter-spacing: 1px;
        }

        .order-history-table {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background: var(--bg-2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        thead {
            background-color: #14213D;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
            font-size: clamp(0.8rem, 2vw, 1rem);
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        img {
            border-radius: 4px;
            max-width: 100vw;
            height: auto;
            object-fit: cover;
        }

        td img {
            max-width: 80px;
        }

        .reorder-btn {
            background-color: #FCA311;
            color: #fff;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .reorder-btn:hover {
            background-color: #e08f00;
        }

        /* Large Desktop */
        @media (min-width: 1200px) {
            .order-history-container {
                margin: 3rem auto;
                padding: 0 2rem;
            }
            
            th, td {
                padding: 1rem 1.5rem;
            }
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .order-history-container {
                margin: 1.5rem auto;
                padding: 0 1rem;
            }
            
            th, td {
                padding: 0.6rem 0.8rem;
            }
        }

        /* Small Tablet */
        @media (max-width: 768px) {
            .order-history-container {
                margin: 1rem auto;
                padding: 0 0.5rem;
            }
            
            .order-history-table {
                border-radius: 6px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            
            table, thead, tbody, th, td, tr {
                display: block;
            }
            
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            
            tr {
                background: var(--bg-2);
                margin-bottom: 1rem;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                border-radius: 8px;
                padding: 1rem;
                border: 1px solid #e0e0e0;
            }
            
            td {
                border: none;
                position: relative;
                padding: 0.5rem 0;
                text-align: left;
                display: block;
                width: 100%;
            }
            
            td::before {
                display: block;
                font-weight: 700;
                color: #333;
                font-size: 0.9rem;
                margin-bottom: 0.25rem;
                content: attr(data-label) ":";
                text-align: left;
            }
            
            td img {
                max-width: 80px;
                height: auto;
                border-radius: 6px;
                margin: 0;
                width: 100%;
            }
            
            td[data-label="Image"] {
                text-align: left;
            }
        }

        /* Mobile */
        @media (max-width: 480px) {
            .order-history-container {
                margin: 0.5rem auto;
                padding: 0 0.25rem;
            }
            
            .order-history-container h2 {
                margin-bottom: 1rem;
                font-size: 1.25rem;
            }
            
            tr {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
            }
            
            td {
                padding: 0.4rem 0;
                font-size: 0.85rem;
                display: block;
                width: 100%;
                text-align: left;
            }
            
            td::before {
                display: block;
                font-size: 0.8rem;
                font-weight: 700;
                color: #333;
                margin-bottom: 0.25rem;
                content: attr(data-label) ":";
            }
        }

        /* Extra Small Mobile */
        @media (max-width: 375px) {
            .order-history-container {
                padding: 0 0.125rem;
            }
            
            .order-history-container h2 {
                font-size: 1.1rem;
            }
            
            tr {
                padding: 0.5rem;
            }
            
            td {
                padding: 0.3rem 0;
                font-size: 0.8rem;
                display: block;
                width: 100%;
                text-align: left;
            }
            
            td::before {
                display: block;
                font-size: 0.75rem;
                font-weight: 700;
                color: #333;
                margin-bottom: 0.25rem;
                content: attr(data-label) ":";
            }
            
            td img {
                /* max-width: 50px; */
            }
            
            td[data-label="Image"] {
                text-align: center;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-width: 768px) and (orientation: landscape) {
            .order-history-container {
                margin: 0.5rem auto;
            }
            
            .order-history-container h2 {
                margin-bottom: 1rem;
                font-size: 1.3rem;
            }
            
            tr {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            tbody tr:hover {
                background-color: rgba(255,255,255,0.05);
            }
            
            @media (max-width: 768px) {
                tr {
                    border-color: rgba(255,255,255,0.1);
                }
                
                td::before {
                    color: rgba(255,255,255,0.8);
                    display: block;
                    margin-bottom: 0.25rem;
                }
            }
        }
    </style>
@endpush

@section('content')
    
    <div class="order-history-container">
        <h2>MY ORDER HISTORY</h2>
        <div class="order-history-table">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Qty</th>
                        <th>Card Number</th>
                        <th>Status</th>
                        <th>Reorder</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @foreach ($order->orderDetails as $detail)
                            <tr>
                                <td data-label="Order ID">{{ $order->id }}</td>
                                <td data-label="Product Name">{{ $detail->product->name ?? 'N/A' }}</td>
                                <td data-label="Image">
                                    @if(isset($detail->product) && $detail->product->image)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}" alt="{{ $detail->product->name }}" loading="lazy">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td data-label="Date">{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                                <td data-label="Qty">{{ $detail->qty }}</td>
                                <td data-label="Card Number">{{ $order->payment_type }}</td>
                                <td data-label="Status">{{ ucfirst($order->order_status) }}</td>
                                <td data-label="Reorder">
                                    <form action="{{ route('order.reorder', $detail->product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="reorder-btn" aria-label="Reorder {{ $detail->product->name ?? 'this item' }}">
                                            Reorder
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding: 2rem;">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrapper">
                {{ $orders->links() }}
            </div>
        </div>
    </div>    

@endsection

@push('scripts')
    <script>
        // Add touch-friendly interactions for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('.order-history-table');
                        
            // Optimize image loading
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.onerror = function() {
                    this.style.display = 'none';
                    this.parentNode.innerHTML = 'N/A';
                };
            });
        });
    </script>
@endpush