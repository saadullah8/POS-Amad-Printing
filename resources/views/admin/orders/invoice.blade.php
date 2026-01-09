@extends('layouts.admin')

@section('content')
<div class="container py-3">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="m-0">Invoice #{{ $order->id }}</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('orders.pos') }}" class="btn btn-secondary">Back to POS</a>

            {{-- Option 1: Print same page --}}
            <button onclick="window.print()" class="btn btn-primary">Print</button>

            {{-- Option 2: Separate print view (auto print) --}}
            <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="btn btn-dark">
                Print (New Tab)
            </a>
        </div>
    </div>

    <div class="card" id="printArea">
        <div class="card-body">

            <div class="text-center mb-3">
                <h5 class="mb-0">Amad Printing & Press</h5>
                <small>Phone: 03xx-xxxxxxx</small><br>
                <small>Date: {{ $order->created_at->format('d M Y, h:i A') }}</small>
            </div>

            <hr>

            <div class="mb-2">
                <strong>Customer:</strong> {{ $order->customer_name ?? 'Walk-in' }} <br>
                <strong>Phone:</strong> {{ $order->customer_phone ?? '-' }} <br>
                <strong>Payment:</strong> {{ strtoupper($order->payment_method) }}
            </div>

            <div class="table-responsive">
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
            </div>

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

            @if($order->notes)
                <hr>
                <div><strong>Notes:</strong> {{ $order->notes }}</div>
            @endif

            <hr>
            <div class="text-center">
                <small>Thanks for your business!</small>
            </div>

        </div>
    </div>
</div>

{{-- Print CSS --}}
<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .btn, .alert, .container > .d-flex { display: none !important; }
}
</style>
@endsection
