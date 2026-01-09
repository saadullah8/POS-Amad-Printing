@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Monthly Report</h5>
            <div class="card-body">

                <form method="GET" action="{{ url('admin/reports/monthly') }}">
                    <div class="row align-items-end">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Select Month</label>
                            <input type="month" name="month" class="form-control" value="{{ request('month') ?? date('Y-m') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <div class="border p-3">
                            <h6 class="mb-1">Total Sale</h6>
                            <h4 class="mb-0">Rs {{ isset($totalSale) ? number_format($totalSale,2) : '0.00' }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border p-3">
                            <h6 class="mb-1">Total Orders</h6>
                            <h4 class="mb-0">{{ $totalOrders ?? 0 }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border p-3">
                            <h6 class="mb-1">Top Service (optional)</h6>
                            <h4 class="mb-0">{{ $topService ?? '-' }}</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($orders) && count($orders))
                                @foreach($orders as $o)
                                    <tr>
                                        <td>{{ $o->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $o->customer_name ?? 'Walk-in' }}</td>
                                        <td>Rs {{ number_format($o->total ?? 0,2) }}</td>
                                        <td>{{ ucfirst($o->payment_method ?? 'cash') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="text-center">No orders found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
