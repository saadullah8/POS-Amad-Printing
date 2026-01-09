@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
        <div class="card">
            <h5 class="card-header">Dashboard</h5>
            <div class="card-body">
                <p class="mb-0">Welcome to Amad Printing & Press POS.</p>
                <small class="text-muted">Use left menu to manage Services, POS Billing and Reports.</small>
            </div>
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Today Sale</h5>
            <div class="card-body">
                <h3 class="mb-0">
                    Rs {{ isset($todaySale) ? number_format($todaySale,2) : '0.00' }}
                </h3>
                <small class="text-muted">Total amount today</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Today Orders</h5>
            <div class="card-body">
                <h3 class="mb-0">{{ $todayOrders ?? 0 }}</h3>
                <small class="text-muted">Bills generated today</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">This Month Sale</h5>
            <div class="card-body">
                <h3 class="mb-0">
                    Rs {{ isset($monthSale) ? number_format($monthSale,2) : '0.00' }}
                </h3>
                <small class="text-muted">Total this month</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Active Services</h5>
            <div class="card-body">
                <h3 class="mb-0">{{ $activeServices ?? 0 }}</h3>
                <small class="text-muted">Services available in POS</small>
            </div>
        </div>
    </div>

    {{-- Recent orders table --}}
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-3">
        <div class="card">
            <h5 class="card-header">Recent Orders</h5>
            <div class="card-body">
                <div class="table-responsive">
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
                            @if(!empty($recentOrders) && count($recentOrders))
                                @foreach($recentOrders as $o)
                                    <tr>
                                        <td>{{ $o->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d-m-Y h:i A') }}</td>
                                        <td>{{ $o->customer_name ?? 'Walk-in' }}</td>
                                        <td>Rs {{ number_format($o->total ?? 0, 2) }}</td>
                                        <td>{{ ucfirst($o->payment_method ?? 'cash') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No recent orders found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            timer: 2200,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session("error") }}',
        });
    @endif
});
</script>

@endsection
