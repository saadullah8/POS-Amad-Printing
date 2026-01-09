@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Services</h5>
            <div class="card-body">

                <div class="mb-3">
                    <a href="{{ url('admin/services/create') }}" class="btn btn-success btn-sm">+ Add Service</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered first">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($values as $value)
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ ucfirst($value->unit) }}</td>
                                    <td>{{ number_format($value->price, 2) }}</td>
                                    <td>
                                        @if($value->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('services.edit', $value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('services.destroy', $value->id) }}"
                                           class="btn btn-danger btn-sm delete-service">Delete</a>
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

    document.querySelectorAll('.delete-service').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            let url = this.getAttribute('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "This service will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success") }}',
            timer: 2500,
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
