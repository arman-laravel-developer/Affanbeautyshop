<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-summary {
            width: 100%;
            margin: 20px 0;
        }

        .invoice-summary th, .invoice-summary td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .invoice-summary th {
            background-color: #f5eadc;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
        }

        .status-section {
            margin: 20px 0;
            font-size: 16px;
            font-weight: bold;
        }

    </style>
</head>
<body>
<p>Hello {{ $data['name'] }},</p>
<p>Thank you for your order! Here is the summary of your order:</p>

<!-- Status Section -->
<div class="status-section">
    <p><strong>Order Status:</strong> {{ ucfirst($data['order']->order_status) }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($data['order']->payment_status) }}</p>
</div>

<!-- Order Summary Table -->
<table class="invoice-summary" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th>Description</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @php
        $grandTotal = 0;
    @endphp
    @foreach($data['order']->orderDetails as $orderDetail)
        @php
            $totalPrice = $orderDetail->price * $orderDetail->qty;
            $grandTotal += $totalPrice;
        @endphp
        <tr>
            <td>{{ $orderDetail->product->name }}</td>
            <td>{{ $orderDetail->size->name }}</td>
            <td>{{ $orderDetail->qty }}</td>
            <td>Tk. {{ number_format($orderDetail->price, 2) }}</td>
            <td>Tk. {{ number_format($totalPrice, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p><strong>Shipping Cost:</strong> Tk. {{ number_format($data['order']->shipping_cost, 2) }}</p>
<p><strong>Discount:</strong> Tk. {{ number_format($data['order']->discount, 2) }}</p>
<p class="total"><strong>Grand Total:</strong> Tk. {{ number_format($grandTotal + $data['order']->shipping_cost - $data['order']->discount, 2) }}</p>

<p>If you have any questions, feel free to contact us at {{$generalSettingView->email}}.</p>
<p>Best regards,</p>
<p>Fashionistaa Haven Team</p>
</body>
</html>
