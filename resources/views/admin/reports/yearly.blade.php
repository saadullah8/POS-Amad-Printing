@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Yearly Report</h5>
            <div class="card-body">

                <form method="GET" action="{{ url('admin/reports/yearly') }}">
                    <div class="row align-items-end">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Select Year</label>
                            <select name="year" class="form-control">
                                @for($y = date('Y'); $y >= date('Y')-5; $y--)
                                    <option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
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
                            <h4 class="mb-0">Rs {{ number_format($totalSale ?? 0,2) }}</h4>
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
                                <th>Month</th>
                                <th>Orders</th>
                                <th>Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($months) && count($months))
                                @foreach($months as $m)
                                    <tr>
                                        <td>{{ $m['month'] }}</td>
                                        <td>{{ $m['orders'] }}</td>
                                        <td>Rs {{ number_format($m['sale'],2) }}</td>
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
