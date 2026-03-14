<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Rack;
use App\Models\OrderRack;
use App\Models\Outlet;
use App\Models\OrderHistory;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    $this->middleware('role:admin,kasir')->only(['index','create','store','print','payment']);
    $this->middleware('role:admin,kasir,karyawan')->only(['updateStatus']);
}

    public function index()
    {
        $orders = Order::orderByDesc('order_date')->get();

        return view('orders.index', compact('orders'));
    }


public function show(Order $order)
{
    $order->load([
        'customer',
        'histories',
        'payments',
        'orderRacks.rack'
    ]);

    return view('orders.show', compact('order'));
}


public function updateStatus(Order $order)
{
    $flow = ['diterima','cuci','jemur','setrika','selesai','diambil'];

    $currentIndex = array_search($order->status, $flow);

    if ($currentIndex !== false && isset($flow[$currentIndex + 1])) {
        $order->update(['status' => $flow[$currentIndex + 1]]);

        // Simpan history
        OrderHistory::create([
            'uuid'       => Str::uuid(),
            'order_code' => $order->order_code,
            'status'     => $order->status,
            'updated_by' => auth()->user()->uuid
        ]);
    }
if ($order->status == 'diambil') {
    OrderRack::where('order_uuid', $order->uuid)
        ->update(['is_done' => true]);
}

    return back();
}

public function create()
{
    $services = Service::orderBy('name')->get();
    return view('orders.create', compact('services'));
}

public function store(Request $request)
{
    DB::beginTransaction();

    try {
        $outlet = Outlet::first();

        // =====================
        // CUSTOMER
        // =====================
        $customer = Customer::create([
            'name'  => $request->customer_name,
            'phone' => $request->customer_phone,
        ]);

        // =====================
        // ORDER
        // =====================
        $order = Order::create([
            'customer_uuid'  => $customer->uuid,
            'outlet_uuid'    => $outlet->uuid,
            'order_code'     => 'ORD-' . now()->format('YmdHis'),
            'invoice_code'   => 'INV-' . now()->format('YmdHis'),
            'order_date'     => now(),
            'status'         => 'diterima',
            'payment_status' => 'Belum',
            'total_price'    => 0,
            'paid_amount'    => 0
        ]);

        // =====================
        // HITUNG VOLUME
        // =====================
        $services = $request->input('services', []);
        $totalVolume = 0;

        foreach ($services as $service_uuid => $qty) {
            $qty = (float) $qty;
            if ($qty <= 0) continue;

            $service = Service::where('uuid', $service_uuid)->first();
            if (!$service) continue;

            $totalVolume += $service->volume * $qty;
        }
//=================
//ABMIL RAK + HITUNG SISA KAPASITAS
//=================
$racks = Rack::where('is_active', true)
    ->orderBy('capacity')
    ->get();

$availableRacks = [];

foreach ($racks as $rack) {

    $usedCapacity = OrderRack::where('rack_uuid', $rack->uuid)
        ->where('is_done', false)
        ->sum('used_capacity');

    $remainingCapacity = $rack->capacity - $usedCapacity;

    if ($remainingCapacity > 0) {
        $rack->remaining_capacity = $remainingCapacity;
        $availableRacks[] = $rack;
    }
}

        // =====================
        // ASSIGN RAK
        // =====================
        $remaining = $totalVolume;

foreach ($availableRacks as $rack) {

    if ($remaining <= 0) break;

    $used = min($rack->remaining_capacity, $remaining);

    OrderRack::create([
        'uuid'          => Str::uuid(),
        'order_uuid'    => $order->uuid,
        'rack_uuid'     => $rack->uuid,
        'used_capacity' => $used,
        'is_done'       => false
    ]);

    $remaining -= $used;
}

        if ($remaining > 0) {
            throw new \Exception('Rak tidak mencukupi');
        }

        // =====================
        // ORDER ITEMS + TOTAL
        // =====================
        $total = 0;

        foreach ($services as $service_uuid => $qty) {
            $qty = (float) $qty;
            if ($qty <= 0) continue;

            $service = Service::where('uuid', $service_uuid)->first();
            if (!$service) continue;

            $subtotal = $service->price * $qty;
            $total += $subtotal;

            OrderItem::create([
                'order_uuid'   => $order->uuid,
                'service_uuid' => $service->uuid,
                'qty'          => $qty,
                'price'        => $service->price,
                'subtotal'     => $subtotal
            ]);
        }

        // =====================
        // PEMBAYARAN (OPSIONAL)
        // =====================
        $paidInput = (int) ($request->payment_amount ?? 0);
        $paidForOrder = min($paidInput, $total);

        $order->update([
            'total_price'    => $total,
            'paid_amount'    => $paidForOrder,
            'payment_status' => $paidInput <= 0
                ? 'Belum'
                : ($paidInput >= $total ? 'Lunas' : 'DP')
        ]);

        if ($paidInput > 0) {
            Payment::create([
                'order_uuid' => $order->uuid,
                'amount'     => $paidInput,
                'method'     => $request->payment_method ?? 'cash',
                'paid_at'    => now()
            ]);
        }

        // =====================
        // HISTORY
        // =====================
        OrderHistory::create([
            'uuid'       => Str::uuid(),
            'order_code' => $order->order_code,
            'status'     => 'diterima',
            'updated_by' => auth()->user()->uuid
        ]);

        DB::commit();
        return redirect()->route('orders.index');

    } catch (\Throwable $e) {
        DB::rollback();
        dd($e->getMessage());
    }
}

public function updatePayment(Order $order)
{
    $flow = ['Belum', 'DP', 'Lunas'];

    $currentIndex = array_search($order->payment_status, $flow);

    if ($currentIndex !== false && isset($flow[$currentIndex + 1])) {
        $order->update(['payment_status' => $flow[$currentIndex + 1]]);
    }

    return back();
}

public function print(Order $order)
{
    $pdf = Pdf::loadView('orders.print', compact('order'));
    return $pdf->stream();
}


public function printAll(Order $order)
{
    $pdf = Pdf::loadView('orders.print-all', compact('order'))
        ->setPaper([0, 0, 226.77, 650]);

    // simpan pdf (WA butuh file fisik)
    $filename = "nota-{$order->order_code}.pdf";
    Storage::put("nota/{$filename}", $pdf->output());

    // auto print
    return $pdf->stream("order-{$order->order_code}.pdf");
}

}
