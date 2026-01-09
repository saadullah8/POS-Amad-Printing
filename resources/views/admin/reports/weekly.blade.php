@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Weekly Report</h5>
            <div class="card-body">

                <form method="GET" action="{{ url('admin/reports/weekly') }}">
                    <div class="row align-items-end">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">From</label>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">To</label>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="border p-3">
                            <h6 class="mb-1">Total Sale</h6>
                            <h4 class="mb-0">Rs {{ isset($totalSale) ? number_format($totalSale,2) : '0.00' }}</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border p-3">
                            <h6 class="mb-1">Total Orders</h6>
                            <h4 class="mb-0">{{ $totalOrders ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Orders</th>
                                <th>Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($days) && count($days))
                                @foreach($days as $d)
                                    <tr>
                                        <td>{{ $d['date'] ?? '-' }}</td>
                                        <td>{{ $d['orders'] ?? 0 }}</td>
                                        <td>Rs {{ number_format($d['sale'] ?? 0,2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="3" class="text-center">No data found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
