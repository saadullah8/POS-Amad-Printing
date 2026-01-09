@extends('layouts.admin')
@section('content')

<div class="row">

    {{-- Left: Billing --}}
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">POS - Create Bill</h5>
            <div class="card-body">

                <form action="{{ route('orders.store') }}" method="POST" id="posForm">
                    @csrf

                    {{-- Customer --}}
                    {{-- <div class="row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Customer Name (optional)</label>
                            <input type="text" name="customer_name" class="form-control"
                                   placeholder="Walk-in customer" value="{{ old('customer_name') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="col-form-label">Customer Phone (optional)</label>
                            <input type="text" name="customer_phone" class="form-control"
                                   placeholder="03xxxxxxxxx" value="{{ old('customer_phone') }}">
                        </div>
                    </div> --}}

                    <hr>

                    {{-- Add service row --}}
                    <div class="row align-items-end">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Select Service</label>
                            <select id="serviceSelect" class="form-control">
                                <option value="">-- Select --</option>
                                @if(!empty($services))
                                    @foreach($services as $s)
                                        <option value="{{ $s->id }}"
                                            data-name="{{ $s->name }}"
                                            data-unit="{{ $s->unit }}"
                                            data-price="{{ $s->price }}">
                                            {{ $s->name }} ({{ $s->unit }}) - Rs {{ number_format($s->price,2) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label class="col-form-label">Quantity</label>
                            <input type="number" min="1" value="1" id="qtyInput" class="form-control">
                        </div>

                        <div class="form-group col-md-3">
                            <button type="button" class="btn btn-primary w-100" id="addItemBtn">Add</button>
                        </div>
                    </div>

                    {{-- Items table --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered first" id="itemsTable">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Unit</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <tr id="emptyRow">
                                    <td colspan="6" class="text-center">No items added yet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Totals --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Subtotal</label>
                            <input type="text" readonly class="form-control" id="subtotalView" value="0.00">
                            <input type="hidden" name="subtotal" id="subtotal">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="col-form-label">Discount</label>
                            <input type="number" min="0" step="0.01" name="discount" id="discount"
                                   class="form-control" value="0">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="col-form-label">Grand Total</label>
                            <input type="text" readonly class="form-control" id="grandTotalView" value="0.00">
                            <input type="hidden" name="total" id="grandTotal">
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                                <option value="card">Card</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label class="col-form-label">Notes (optional)</label>
                            <input type="text" name="notes" class="form-control" placeholder="Any note...">
                        </div>
                    </div>

                    {{-- Hidden items container --}}
                    <div id="itemsInputs"></div>

                   <div class="mt-3 d-flex flex-wrap gap-2">
    <button type="submit" class="btn btn-success px-5" id="saveBillBtn">Save Bill</button>

    <a href="{{ route('orders.pos') }}" class="btn btn-light">Reset</a>

    {{-- ✅ Show after save --}}
    @if(session('print_order_id'))
        <a href="{{ route('orders.invoice', session('print_order_id')) }}"
           class="btn btn-dark">
            Invoice
        </a>

        <a href="{{ route('orders.print', session('print_order_id')) }}"
           target="_blank"
           class="btn btn-primary">
            Print
        </a>
    @endif
</div>

                </form>

            </div>
        </div>
    </div>

    {{-- Right: Receipt Preview --}}
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Receipt Preview</h5>
            <div class="card-body">
                <div class="border p-3" id="receiptBox">
                    <h6 class="text-center mb-2">Amad Printing & Press</h6>
                    <hr class="my-2">

                    <div id="receiptItems" style="font-size: 13px;">
                        <p class="text-muted mb-0">Items will show here...</p>
                    </div>

                    <hr class="my-2">

                    <div style="font-size: 13px;">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span><span id="rSubtotal">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Discount</span><span id="rDiscount">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Total</span><span id="rTotal">0.00</span>
                        </div>
                    </div>

                    <hr class="my-2">
                    <p class="text-center mb-0" style="font-size: 12px;">Thank you!</p>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    let items = []; // {service_id, name, unit, qty, unit_price, total}

    function money(n){ return (Number(n) || 0).toFixed(2); }

    function recalc(){
        let subtotal = items.reduce((sum, it) => sum + (Number(it.total) || 0), 0);
        let discount = Number(document.getElementById('discount').value || 0);
        if(discount < 0) discount = 0;
        if(discount > subtotal) discount = subtotal;

        let grand = subtotal - discount;

        document.getElementById('subtotal').value = subtotal;
        document.getElementById('subtotalView').value = money(subtotal);

        document.getElementById('grandTotal').value = grand;
        document.getElementById('grandTotalView').value = money(grand);

        // receipt
        document.getElementById('rSubtotal').innerText = money(subtotal);
        document.getElementById('rDiscount').innerText = money(discount);
        document.getElementById('rTotal').innerText = money(grand);
    }

    function render(){
        const body = document.getElementById('itemsBody');
        const inputs = document.getElementById('itemsInputs');
        const receipt = document.getElementById('receiptItems');

        body.innerHTML = '';
        inputs.innerHTML = '';
        receipt.innerHTML = '';

        if(items.length === 0){
            body.innerHTML = `<tr><td colspan="6" class="text-center">No items added yet.</td></tr>`;
            receipt.innerHTML = `<p class="text-muted mb-0">Items will show here...</p>`;
            recalc();
            return;
        }

        items.forEach((it, idx) => {
            body.innerHTML += `
                <tr>
                    <td>${it.name}</td>
                    <td>${it.unit}</td>
                    <td>${it.qty}</td>
                    <td>${money(it.unit_price)}</td>
                    <td>${money(it.total)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeBtn" data-index="${idx}">Remove</button>
                    </td>
                </tr>
            `;

            inputs.innerHTML += `
                <input type="hidden" name="items[${idx}][service_id]" value="${it.service_id}">
                <input type="hidden" name="items[${idx}][qty]" value="${it.qty}">
                <input type="hidden" name="items[${idx}][unit_price]" value="${it.unit_price}">
                <input type="hidden" name="items[${idx}][total]" value="${it.total}">
            `;

            receipt.innerHTML += `
                <div class="d-flex justify-content-between">
                    <span>${it.name} (${it.qty} ${it.unit})</span>
                    <span>${money(it.total)}</span>
                </div>
            `;
        });

        recalc();
    }

    document.getElementById('addItemBtn').addEventListener('click', () => {
        const sel = document.getElementById('serviceSelect');
        const opt = sel.options[sel.selectedIndex];
        const serviceId = sel.value;

        if(!serviceId){
            Swal.fire({icon:'error', title:'Select service', text:'Please select a service first.'});
            return;
        }

        let qty = Number(document.getElementById('qtyInput').value || 1);
        if(qty < 1) qty = 1;

        const name = opt.getAttribute('data-name');
        const unit = opt.getAttribute('data-unit');
        const price = Number(opt.getAttribute('data-price') || 0);
        const total = qty * price;

        // If same service already added, merge qty
        const existingIndex = items.findIndex(x => x.service_id == serviceId);
        if(existingIndex !== -1){
            items[existingIndex].qty = Number(items[existingIndex].qty) + qty;
            items[existingIndex].total = Number(items[existingIndex].qty) * Number(items[existingIndex].unit_price);
        } else {
            items.push({
                service_id: serviceId,
                name: name,
                unit: unit,
                qty: qty,
                unit_price: price,
                total: total
            });
        }

        // reset
        sel.value = '';
        document.getElementById('qtyInput').value = 1;

        render();
    });

    document.getElementById('itemsTable').addEventListener('click', (e) => {
        if(e.target.classList.contains('removeBtn')){
            const idx = Number(e.target.getAttribute('data-index'));
            items.splice(idx, 1);
            render();
        }
    });

    document.getElementById('discount').addEventListener('input', recalc);

    document.getElementById('posForm').addEventListener('submit', (e) => {
        if(items.length === 0){
            e.preventDefault();
            Swal.fire({icon:'error', title:'No items', text:'Please add at least 1 service item.'});
        }
    });

    // toaster messages
    @if(session('success'))
        Swal.fire({ icon:'success', title:'Success!', text:'{{ session("success") }}', timer:2200, showConfirmButton:false });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Oops!', text:'{{ session("error") }}' });
    @endif

});
</script>

@endsection
