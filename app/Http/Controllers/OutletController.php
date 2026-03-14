<?php
namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::orderBy('name')->get();
        return view('outlets.index', compact('outlets'));
    }

    public function create()
    {
        return view('outlets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'phone' => 'required|unique:outlets,phone',
            'address' => 'nullable'
        ]);

        Outlet::create($request->only('name','phone','address'));

        return redirect()->route('outlets.index')
            ->with('success', 'Outlet berhasil ditambahkan');
    }
}
