@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Add Service</h5>
            <div class="card-body">

                <form action="{{ route('services.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Service Name</label>
                            <input name="name" type="text" class="form-control"
                                   placeholder="e.g. Photostat"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label class="col-form-label">Unit</label>
                            <select name="unit" class="form-control" required>
                                <option value="">Select Unit</option>
                                <option value="page"  {{ old('unit')=='page' ? 'selected' : '' }}>Page</option>
                                <option value="piece" {{ old('unit')=='piece' ? 'selected' : '' }}>Piece</option>
                                <option value="job"   {{ old('unit')=='job' ? 'selected' : '' }}>Job</option>
                            </select>
                            @error('unit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label class="col-form-label">Price</label>
                            <input name="price" type="number" step="0.01" min="0"
                                   class="form-control"
                                   placeholder="0"
                                   value="{{ old('price') }}" required>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label class="col-form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status','1')=='1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary px-5">Save Service</button>
                        <a href="{{ url('admin/services/index') }}" class="btn btn-light">Back</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
