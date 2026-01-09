<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public function index()
    {
        $values = Service::orderBy('id', 'desc')->get();

        $data = [
            'heading' => 'Services',
            'title'   => 'View Services',
            'active'  => 'services',
            'values'  => $values,
        ];

        return view('admin.services.index', $data);
    }

    public function create()
    {
        $data = [
            'heading' => 'Add Service',
            'title'   => 'Create Service',
            'active'  => 'services',
        ];

        return view('admin.services.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'   => 'required|string|max:255|unique:services,name',
                'unit'   => 'required|in:page,piece,job',
                'price'  => 'required|numeric|min:0',
                'status' => 'required|in:0,1',
            ],
            [
                'unit.in' => 'Unit must be page, piece or job.',
            ]
        );

        if ($validator->fails()) {
            if ($validator->errors()->has('name')) {
                return redirect()->back()->with('error', 'This service name already exists!')->withInput();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        $data = [
            'heading' => 'Edit Service',
            'title'   => 'Update Service',
            'active'  => 'services',
            'service' => $service,
        ];

        return view('admin.services.edit', $data);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make(
            $request->all(),
            [
                'id'     => 'required|exists:services,id',
                'name'   => 'required|string|max:255|unique:services,name,' . $id,
                'unit'   => 'required|in:page,piece,job',
                'price'  => 'required|numeric|min:0',
                'status' => 'required|in:0,1',
            ],
            [
                'unit.in' => 'Unit must be page, piece or job.',
            ]
        );

        if ($validator->fails()) {
            if ($validator->errors()->has('name')) {
                return redirect()->back()->with('error', 'This service name already exists!')->withInput();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    // ✅ Delete via GET (as you want)
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
