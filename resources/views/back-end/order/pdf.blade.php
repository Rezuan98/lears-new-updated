<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .order-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-row {
            border-top: 2px solid #000;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('frontend/images/new-leaars-logo.jpg'))) }}" style="width:150px;height:80px;">
        </div>
        <h2 style="margin-top: 15px;">Order Invoice</h2>
        <p>Order #{{ $order->order_number }}</p>
        <p>Date: {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <div class="order-info">
        <div style="float: left; width: 50%;">
            <h3>Order Information</h3>
            <p>Order Date: {{ $order->created_at->format('d M Y h:i A') }}</p>
            <p>Payment Method: {{ strtoupper($order->payment_method) }}</p>
            <p>Status: {{ ucfirst($order->order_status) }}</p>
        </div>
        
        <div style="float: right; width: 50%;">
            <h3>Customer Information</h3>
            <p>{{ $order->name }}</p>
            <p>{{ $order->email }}</p>
            <p>{{ $order->phone }}</p>
            <p>{{ $order->address }}</p>
            <p>{{ $order->city }}, {{ $order->postal_code }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Color</th>
                <th>Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>{{ $item->variant_color  }}</td>
                <td>{{ $item->variant_size  }}</td>
                <td>{{ number_format((float)$item->price, 2, '.', ',') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format((float)$item->subtotal, 2, '.', ',') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>{{ number_format((float)$order->subtotal, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td>Shipping:</td>
                <td>{{ number_format((float)$order->shipping_charge, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td>{{ number_format((float)$order->tax, 2, '.', ',') }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>Total:</strong></td>
                <td><strong>{{ number_format((float)$order->total, 2, '.', ',') }}-/</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>