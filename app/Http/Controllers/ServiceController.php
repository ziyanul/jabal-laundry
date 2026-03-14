<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $services = Service::orderBy('name')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string',
            'unit'   => 'required|in:kg,pcs',
            'price'  => 'required|numeric|min:0',
            'volume' => 'required|numeric|min:1',
        ]);

        Service::create([
            'uuid'   => Str::uuid(),
            'name'   => $request->name,
            'unit'   => $request->unit,
            'price'  => $request->price,
            'volume' => $request->volume,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil ditambahkan');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name'   => 'required|string',
            'unit'   => 'required|in:kg,pcs',
            'price'  => 'required|numeric|min:0',
            'volume' => 'required|numeric|min:1',
        ]);

        $service->update($request->only('name','unit','price','volume'));

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil diperbarui');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil dihapus');
    }
}
