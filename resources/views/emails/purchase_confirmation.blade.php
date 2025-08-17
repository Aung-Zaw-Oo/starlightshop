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
            background: #14213D;
            color: #FCA311;
            text-align: center;
            padding: 20px;
            font-size: 1.6rem;
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
            color: #14213D;
        }
        .order-box {
            background: #F9F9F9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #14213D;
            margin-top: 15px;
        }
        .order-items {
            margin-top: 15px;
            border-collapse: collapse;
            width: 100%;
        }
        .order-items th, .order-items td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 0.95rem;
        }
        .order-items th {
            background: #F5F5F5;
            font-weight: 600;
            color: #14213D;
        }
        .footer {
            background: #FCA311;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            color: #14213D;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            ✨ Purchase Confirmation
        </div>
        <div class="content">
            <p>Hi <span class="label">{{ $order->customer->name }}</span>,</p>
            <p>Thank you for shopping with <strong>StarLight Store</strong>!  
               Your order has been placed successfully. Below are the details:</p>

            <div class="order-box">
                <p><span class="label">Order ID:</span> #{{ $order->id }}</p>
                <p><span class="label">Order Date:</span> {{ $order->order_date->format('M d, Y h:i A') }}</p>
                <p><span class="label">Payment:</span> {{ $order->payment_type }}</p>
                <p><span class="label">Total:</span> ${{ number_format($order->total_price, 2) }}</p>
            </div>

            <table class="order-items">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>${{ number_format($detail->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p>If you have any questions, feel free to reply to this email.</p>
        </div>
        <div class="footer">
            StarLight Store ✨ | Thank you for your purchase!
        </div>
    </div>
</body>
</html>
