<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    // Hanya admin yang bisa CRUD customer
    $this->middleware('role:admin');
}

    public function index()
    {
        $customers = Customer::orderBy('name')->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'phone' => 'nullable',
            'address' => 'nullable'
        ]);

        Customer::create($request->only('name','phone','address'));

        return redirect()->route('customers.index')
            ->with('success', 'Customer berhasil ditambahkan');
    }
}
