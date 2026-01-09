@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Create Order</h5>
            <div class="card-body">
                <p class="mb-2">Orders are created from POS screen.</p>
                <a href="{{ url('admin/pos/index') }}" class="btn btn-success">Go to POS</a>
            </div>
        </div>
    </div>
</div>

@endsection
