<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    // Admin & Kasir yang bisa input pembayaran
    $this->middleware('role:admin,kasir');
}

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required'
        ]);

        DB::transaction(function () use ($request, $order) {

            // simpan payment (uang fisik)
            Payment::create([
                'order_uuid' => $order->uuid,
                'amount'     => $request->amount,
                'method'     => $request->method,
                'paid_at'    => now()
            ]);

            // hitung ulang total bayar
            $totalPaid = Payment::where('order_uuid', $order->uuid)
                ->sum('amount');

            // nilai yg diakui utk order (tidak boleh > total)
            $paidForOrder = min($totalPaid, $order->total_price);

            // status
            if ($paidForOrder <= 0) {
                $status = 'Belum';
            } elseif ($paidForOrder < $order->total_price) {
                $status = 'DP';
            } else {
                $status = 'Lunas';
            }

            $order->update([
                'paid_amount'    => $paidForOrder,
                'payment_status' => $status
            ]);
        });

        return back()->with('success', 'Pembayaran berhasil');
    }
}
