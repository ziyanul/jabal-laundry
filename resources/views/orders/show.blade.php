@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">

    <h1 class="text-xl font-bold">{{ $order->order_code }}</h1>

    <div class="bg-white rounded-xl p-4 shadow space-y-2">
        <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
        <p><strong>Status:</strong> {{ strtoupper($order->status) }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total_price) }}</p>
    </div>

    <div class="bg-white rounded-xl p-4 shadow">
        <h2 class="font-semibold mb-2">Timeline</h2>

        <ul class="space-y-2 text-sm">
    @foreach ($order->histories as $history)
        <li>● {{ strtoupper($history->status) }}
            <span class="text-gray-500">
                ({{ $history->created_at->format('d/m H:i') }})
            </span>
        </li>
    @endforeach
</ul>
    </div>

    <div class="card mt-3">
    <div class="card-header">
        <strong>Lokasi Rak</strong>
    </div>
    <div class="card-body">
        @forelse ($order->orderRacks as $or)
            <span class="badge bg-primary me-2">
                Rak {{ $or->rack->code }}
                ({{ $or->used_capacity }})
            </span>
        @empty
            <span class="text-muted">Belum dialokasikan</span>
        @endforelse
    </div>
</div>


<div class="bg-white rounded-xl p-4 shadow space-y-2">
    <h2 class="font-semibold">Status Pembayaran</h2>

    <p class="text-sm mb-2">
        <span class="ml-2 px-2 py-1 rounded-full 
            @if($order->payment_status == 'Belum') bg-gray-200
            @elseif($order->payment_status == 'DP') bg-yellow-200
            @else bg-green-200
            @endif
            text-xs">
            {{ $order->payment_status }}
        </span>
    </p>
@if($order->payments->count())
<hr>

<h3 class="font-semibold mb-2">Riwayat Pembayaran</h3>

<table class="w-full text-sm border">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Metode</th>
            <th class="p-2 border text-right">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->payments as $pay)
        <tr>
            <td class="p-2 border">
                {{ $pay->paid_at->format('d/m/Y H:i') }}
            </td>
            <td class="p-2 border">
                {{ strtoupper($pay->method) }}
            </td>
            <td class="p-2 border text-right">
                Rp {{ number_format($pay->amount) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

    @if($order->payment_status !== 'Lunas')
<hr>    

<h3 class="font-semibold mb-2">Bayar Sisa</h3>

<form method="POST" action="{{ route('orders.payment', $order->order_code) }}">
    @csrf

    <div class="mb-2">
        <label>Jumlah Bayar</label>
        <input type="number" name="amount"
               class="w-full border rounded p-2"
               required>
    </div>

    <div class="mb-2">
        <label>Metode</label>
        <select name="method" class="w-full border rounded p-2" required>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="qris">QRIS</option>
        </select>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Bayar
    </button>
</form>
@endif

</div>

@if($order->status != 'diambil')
<form method="POST"
      action="{{ route('orders.update-status', $order->order_code) }}">
    @csrf
    <button class="w-full bg-green-600 text-white py-2 rounded-lg">
        Lanjutkan Status
    </button>
</form>
@endif

<a href="{{ route('orders.print.all', $order) }}"
   target="_blank"
   class="w-full bg-gray-800 text-white py-2 rounded-lg text-center block">
    Cetak Nota
</a>
@php
$notaUrl = route('orders.print', $order->order_code);


$text = urlencode(
"NOTA LAUNDRY\n".
"Kode: {$order->code}\n".
"Customer: {$order->customer_name}\n".
"Total: Rp ".number_format($order->total_price)."\n".
"Bayar: Rp ".number_format($order->paid_amount)."\n".
"Sisa: Rp ".number_format($order->remaining_payment)."\n\n".
"Lihat nota:\n{$notaUrl}"
);
@endphp

<a href="https://wa.me/62{{ $order->customer_phone }}?text={{ $text }}"
   target="_blank"
   class="w-full bg-blue-800 text-white py-2 rounded-lg text-center block">
   📲 Kirim via WhatsApp
</a>

</div>
@endsection
