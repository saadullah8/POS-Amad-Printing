<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Invoice #{{ $order->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display:none !important; }
        }
    </style>
</head>
<body class="p-3">

<div class="no-print mb-3 d-flex justify-content-end gap-2">
    <button onclick="window.print()" class="btn btn-primary">Print</button>
    <button onclick="window.close()" class="btn btn-secondary">Close</button>
</div>

<div id="printArea">
    <div class="text-center mb-3">
        <h5 class="mb-0">Amad Printing & Press</h5>
        <small>Date: {{ $order->created_at->format('d M Y, h:i A') }}</small>
        <div><strong>Invoice #{{ $order->id }}</strong></div>
    </div>

    <hr>

    <div class="mb-2">
        <strong>Customer:</strong> {{ $order->customer_name ?? 'Walk-in' }} <br>
        <strong>Phone:</strong> {{ $order->customer_phone ?? '-' }} <br>
        <strong>Payment:</strong> {{ strtoupper($order->payment_method) }}
    </div>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Service</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Rate</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->service->name ?? 'Service' }}</td>
                <td class="text-end">{{ $item->qty }}</td>
                <td class="text-end">{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-end">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <div class="d-flex justify-content-end">
        <div style="min-width: 260px;">
            <div class="d-flex justify-content-between">
                <span>Subtotal</span>
                <strong>{{ number_format($order->subtotal, 2) }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Discount</span>
                <strong>{{ number_format($order->discount, 2) }}</strong>
            </div>
            <div class="d-flex justify-content-between fs-5 mt-2">
                <span>Total</span>
                <strong>{{ number_format($order->total, 2) }}</strong>
            </div>
        </div>
    </div>

    <hr>
    <div class="text-center"><small>Thanks for your business!</small></div>
</div>

<script>
    window.onload = function () {
        window.print();
    };
</script>

</body>
</html>
