<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #E5E5E5;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .header {
            background: #B00020;
            color: #FFFFFF;
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .content {
            padding: 25px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .content p {
            margin: 10px 0;
        }
        .label {
            font-weight: 600;
            color: #B00020;
        }
        .order-details {
            background: #F9F9F9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #B00020;
        }
        .item-list {
            margin: 20px 0;
        }
        .item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        .total {
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #B00020;
        }
        .footer {
            background: #B00020;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            color: #FFFFFF;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            ⚠️ Order Cancelled / Refunded
        </div>

        <div class="content">
            <p>Hi <span class="label">{{ $order->customer->name }}</span>,</p>
            <p>Your order has been <strong>cancelled</strong> and refunded. Here are the details:</p>

            <div class="order-details">
                <p><span class="label">Order ID:</span> #{{ $order->id }}</p>
                <p><span class="label">Total:</span> ${{ number_format($order->total_price, 2) }}</p>
                <p><span class="label">Order Date:</span> {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') }}</p>
                <p><span class="label">Payment Method:</span> {{ $order->payment_type }}</p>
            </div>

            <div class="item-list">
                <h3>Items Ordered:</h3>
                @foreach($order->orderDetails as $detail)
                    <div class="item">
                        <div>
                            <strong>{{ $detail->product->name ?? 'Product #' . $detail->product_id }}</strong>
                            <br>
                            <small>Quantity: {{ $detail->qty }}</small>
                        </div>
                        <div>
                            ${{ number_format($detail->price * $detail->qty, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="total">
                Total Refunded: ${{ number_format($order->total_price, 2) }}
            </div>

            <p>If you have any questions about this cancellation or refund, please contact our support team.</p>
        </div>

        <div class="footer">
            StarLight Store ✨ | Your satisfaction is our priority
        </div>
    </div>
</body>
</html>
