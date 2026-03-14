<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    // Semua role bisa lihat dashboard
    $this->middleware('role:admin,kasir,karyawan,owner');
}

    public function index()
    {
        // sementara dummy data
        $data = [
            'total_order_today' => 0,
            'order_process'     => 0,
            'order_done'        => 0,
            'omzet_today'       => 0,
        ];

        return view('dashboard.index', $data);
    }
}
