@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Edit Order #{{ $order->id }}</h5>
            <div class="card-body">

                <form action="{{ route('orders.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control"
                                   value="{{ old('customer_name', $order->customer_name) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="col-form-label">Customer Phone</label>
                            <input type="text" name="customer_phone" class="form-control"
                                   value="{{ old('customer_phone', $order->customer_phone) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="col-form-label">Subtotal</label>
                            <input type="text" readonly class="form-control"
                                   value="{{ number_format($order->subtotal,2) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="col-form-label">Discount</label>
                            <input type="number" min="0" step="0.01" name="discount"
                                   class="form-control"
                                   value="{{ old('discount', $order->discount) }}">
                            @error('discount') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label class="col-form-label">Total</label>
                            <input type="text" readonly class="form-control"
                                   value="{{ number_format($order->total,2) }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="col-form-label">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="cash"   {{ old('payment_method', $order->payment_method)=='cash' ? 'selected' : '' }}>Cash</option>
                                <option value="online" {{ old('payment_method', $order->payment_method)=='online' ? 'selected' : '' }}>Online</option>
                                <option value="card"   {{ old('payment_method', $order->payment_method)=='card' ? 'selected' : '' }}>Card</option>
                            </select>
                            @error('payment_method') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group col-md-8">
                            <label class="col-form-label">Notes</label>
                            <input type="text" name="notes" class="form-control"
                                   value="{{ old('notes', $order->notes) }}">
                        </div>
                    </div>

                    <hr>

                    <h6>Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $it)
                                    <tr>
                                        <td>{{ $it->service->name ?? '-' }}</td>
                                        <td>{{ $it->qty }}</td>
                                        <td>{{ number_format($it->unit_price,2) }}</td>
                                        <td>{{ number_format($it->total,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary px-5">Update</button>
                        <a href="{{ url('admin/orders/index') }}" class="btn btn-light">Back</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
