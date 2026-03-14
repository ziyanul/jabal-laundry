<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $racks = Rack::orderBy('code')->get();
        return view('racks.index', compact('racks'));
    }

    public function create()
    {
        return view('racks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'     => 'required|unique:racks,code',
            'capacity' => 'required|numeric|min:1'
        ]);

        Rack::create([
            'uuid'     => Str::uuid(),
            'code'     => $request->code,
            'capacity' => $request->capacity,
            'is_active'=> true
        ]);

        return redirect()->route('racks.index')
            ->with('success', 'Rak berhasil ditambahkan');
    }

    public function edit(Rack $rack)
    {
        return view('racks.edit', compact('rack'));
    }

    public function update(Request $request, Rack $rack)
    {
        $request->validate([
            'code'     => 'required|unique:racks,code,' . $rack->id,
            'capacity' => 'required|numeric|min:1'
        ]);

        $rack->update($request->only('code','capacity','is_active'));

        return redirect()->route('racks.index')
            ->with('success', 'Rak diperbarui');
    }

    public function destroy(Rack $rack)
    {
        $rack->delete();

        return redirect()->route('racks.index')
            ->with('success', 'Rak dihapus');
    }
}
