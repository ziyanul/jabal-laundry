<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;
\Carbon\Carbon::setLocale('id');
use DB;

class ReportController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    // Hanya admin yang bisa akses report
    $this->middleware('role:admin');
}

   public function cashDaily(Request $request)
{
    $start = $request->start_date;
    $end   = $request->end_date;

    // =====================
    // DETAIL PAYMENT
    // =====================
    $paymentsQuery = Payment::with('order')
        ->when($start && $end, function ($q) use ($start, $end) {
            $q->whereBetween(
                DB::raw('DATE(paid_at)'),
                [$start, $end]
            );
        });

    $payments = $paymentsQuery->orderBy('paid_at', 'desc')->get();

    // =====================
    // SUMMARY
    // =====================
    $summary = [
        'count'     => $payments->count(),
        'total'     => $payments->sum('amount'),
        'cash'      => $payments->where('method', 'cash')->sum('amount'),
        'transfer'  => $payments->where('method', 'transfer')->sum('amount'),
        'qris'      => $payments->where('method', 'qris')->sum('amount'),
    ];

    // =====================
    // REKAP PER TANGGAL
    // =====================
    $data = DB::table('payments')
        ->select(
            DB::raw('DATE(paid_at) as tanggal'),
            DB::raw('SUM(amount) as total')
        )
        ->when($start && $end, function ($q) use ($start, $end) {
            $q->whereBetween(
                DB::raw('DATE(paid_at)'),
                [$start, $end]
            );
        })
        ->groupBy(DB::raw('DATE(paid_at)'))
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('reports.cash-daily', compact(
        'payments',
        'summary',
        'data',
        'start',
        'end'
    ));
}

}
