@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Orders</h5>
            <div class="card-body">

                <div class="mb-3">
                    <a href="{{ url('admin/pos/index') }}" class="btn btn-success btn-sm">+ New Bill (POS)</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Action</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($values as $o)
                                <tr>
                                    <td>{{ $o->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d-m-Y h:i A') }}</td>
                                    <td>{{ $o->customer_name ?? 'Walk-in' }}</td>
                                    <td>Rs {{ number_format($o->total ?? 0,2) }}</td>
                                    <td>{{ ucfirst($o->payment_method) }}</td>
                                    <td>
                                        <a href="{{ route('orders.edit', $o->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.destroy', $o->id) }}" class="btn btn-danger btn-sm delete-order">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
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

    document.querySelectorAll('.delete-order').forEach(btn => {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            let url = this.getAttribute('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "This order will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.isConfirmed){
                    window.location.href = url;
                }
            });
        });
    });

    @if(session('success'))
    Swal.fire({ icon:'success', title:'Success!', text:'{{ session("success") }}', timer:2200, showConfirmButton:false });
    @endif

    @if(session('error'))
    Swal.fire({ icon:'error', title:'Oops!', text:'{{ session("error") }}' });
    @endif
});
</script>

@endsection
