@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">

    <h1 class="text-xl font-bold">Dashboard Jabal Laundry</h1>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-blue-500 text-white rounded-xl p-4">
            <p class="text-sm">Order Hari Ini</p>
            <p class="text-2xl font-bold">{{ $total_order_today }}</p>
        </div>

        <div class="bg-yellow-500 text-white rounded-xl p-4">
            <p class="text-sm">Dalam Proses</p>
            <p class="text-2xl font-bold">{{ $order_process }}</p>
        </div>

        <div class="bg-green-500 text-white rounded-xl p-4">
            <p class="text-sm">Selesai</p>
            <p class="text-2xl font-bold">{{ $order_done }}</p>
        </div>

        <div class="bg-purple-500 text-white rounded-xl p-4">
            <p class="text-sm">Omzet Hari Ini</p>
            <p class="text-2xl font-bold">Rp {{ number_format($omzet_today) }}</p>
        </div>
    </div>

</div>
@endsection
