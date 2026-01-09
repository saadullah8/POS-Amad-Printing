<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    // Orders list
    public function index()
    {
        $values = Order::orderBy('id', 'desc')->get();

        $data = [
            'heading' => 'Orders',
            'title'   => 'View Orders',
            'active'  => 'orders',
            'values'  => $values,
        ];

        return view('admin.orders.index', $data);
    }

    // Optional create screen (if you want separate page)
    public function create()
    {
        $data = [
            'heading' => 'Create Order',
            'title'   => 'Create Order',
            'active'  => 'orders',
        ];

        return view('admin.orders.create', $data);
    }

    // POS screen
    public function pos()
    {
        $services = Service::where('status', 1)->orderBy('name')->get();

        $data = [
            'heading'  => 'POS',
            'title'    => 'POS Billing',
            'active'   => 'pos',
            'services' => $services,
        ];

        return view('admin.pos.index', $data);
    }

    // Store order from POS
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items'          => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.qty'        => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total'      => 'required|numeric|min:0',
            'subtotal'       => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0',
            'total'          => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,online,card',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please fix the form errors.')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'subtotal'       => $request->subtotal,
                'discount'       => $request->discount ?? 0,
                'total'          => $request->total,
                'payment_method' => $request->payment_method,
                'notes'          => $request->notes,
                'created_by'     => Auth::check() ? Auth::id() : null,
            ]);

            foreach ($request->items as $it) {
                OrderItem::create([
                    'order_id'    => $order->id,
                    'service_id'  => $it['service_id'],
                    'qty'         => $it['qty'],
                    'unit_price'  => $it['unit_price'],
                    'total'       => $it['total'],
                ]);
            }

            DB::commit();
            return redirect()->route('orders.invoice', $order->id)
                ->with('success', 'Bill saved successfully! Now you can print it.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong while saving bill!')->withInput();
        }
    }

    // Edit order
    public function edit($id)
    {
        $order = Order::with('items.service')->findOrFail($id);

        $data = [
            'heading' => 'Edit Order',
            'title'   => 'Update Order',
            'active'  => 'orders',
            'order'   => $order,
        ];

        return view('admin.orders.edit', $data);
    }

    // Update (POST) - only order fields (not items) to keep safe
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'            => 'required|exists:orders,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone'=> 'nullable|string|max:20',
            'discount'      => 'required|numeric|min:0',
            'payment_method'=> 'required|in:cash,online,card',
            'notes'         => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Please fix the form errors.')->withErrors($validator)->withInput();
        }

        $order = Order::findOrFail($request->id);

        // Recalculate total = subtotal - discount
        $discount = (float)$request->discount;
        if ($discount > (float)$order->subtotal) {
            $discount = (float)$order->subtotal;
        }

        $order->update([
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'discount'       => $discount,
            'total'          => (float)$order->subtotal - $discount,
            'payment_method' => $request->payment_method,
            'notes'          => $request->notes,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }
    public function invoice($id)
    {
        $order = Order::with(['items.service'])->findOrFail($id);

        $data = [
            'heading' => 'Invoice',
            'title'   => 'Invoice #' . $order->id,
            'active'  => 'orders',
            'order'   => $order,
        ];

        return view('admin.orders.invoice', $data);
    }

    // Optional: a pure print view (auto print)
    public function print($id)
    {
        $order = Order::with(['items.service'])->findOrFail($id);

        return view('admin.orders.print', compact('order'));
    }

    // Delete via GET (your style)
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete(); // cascade will delete items

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
