@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4">

    <h1 class="text-xl font-bold">Daftar Order</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($orders as $order)
    <a href="{{ route('orders.show', $order->order_code) }}" class="block">
        <div class="border rounded-xl p-4 shadow-md bg-white hover:shadow-lg transition">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <p class="font-semibold">{{ $order->order_code }}</p>
                    <p class="text-sm text-gray-500">{{ $order->customer->name ?? '-' }}</p>
                </div>
                <span class="text-xs px-3 py-1 rounded-full 
    @if($order->payment_status == 'Belum') bg-gray-200
    @elseif($order->payment_status == 'DP') bg-yellow-200
    @else bg-green-500 text-white
    @endif
">
    {{ $order->payment_status }}
</span>

                <span class="text-xs px-3 py-1 rounded-full
                    @switch($order->status)
                        @case('diterima') bg-gray-200 text-gray-800 @break
                        @case('cuci')    bg-blue-200 text-blue-800 @break
                        @case('jemur')   bg-yellow-200 text-yellow-800 @break
                        @case('setrika') bg-purple-200 text-purple-800 @break
                        @case('siap_ambil') bg-teal-200 text-teal-800 @break
                        @case('selesai') bg-green-500 text-white @break
                        @default bg-gray-100
                    @endswitch
                ">
                    {{ strtoupper($order->status) }}
                </span>

            </div>

            <div class="flex justify-between text-sm text-gray-600">
                <span>Total: Rp {{ number_format($order->total_price) }}</span>
                <span>{{ $order->order_date->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </a>
@empty
    <p>Belum ada order</p>
@endforelse

    </div>

</div>
@endsection
