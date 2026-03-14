@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    {{-- TITLE --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">
            Laporan Kas Harian
        </h1>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('reports.cash-daily') }}"
          class="bg-white p-4 rounded-lg shadow flex flex-wrap gap-3 items-end">

        <div class="flex flex-col">
            <label class="text-sm text-gray-600 mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date"
                   value="{{ request('start_date') }}"
                   class="border rounded px-3 py-2">
        </div>

        <div class="flex flex-col">
            <label class="text-sm text-gray-600 mb-1">Tanggal Akhir</label>
            <input type="date" name="end_date"
                   value="{{ request('end_date') }}"
                   class="border rounded px-3 py-2">
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
            <a href="{{ route('reports.cash-daily') }}"
               class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                Reset
            </a>
        </div>
    </form>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @php
            $cards = [
                ['label'=>'Transaksi','value'=>$summary['count'],'bg'=>'gray'],
                ['label'=>'Total Masuk','value'=>$summary['total'],'bg'=>'green'],
                ['label'=>'Cash','value'=>$summary['cash'],'bg'=>'blue'],
                ['label'=>'Transfer','value'=>$summary['transfer'],'bg'=>'yellow'],
                ['label'=>'QRIS','value'=>$summary['qris'],'bg'=>'purple'],
            ];
        @endphp

        @foreach($cards as $c)
        <div class="bg-{{ $c['bg'] }}-100 p-4 rounded-lg">
            <div class="text-sm text-gray-600">{{ $c['label'] }}</div>
            <div class="text-lg font-bold">
                {{ is_numeric($c['value']) ? 'Rp '.number_format($c['value']) : $c['value'] }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- REKAP HARIAN --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 font-semibold border-b">Rekap Per Tanggal</div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-right">Total Kas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                <tr class="border-t">
                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l, d F Y') }}
                    </td>
                    <td class="p-3 text-right font-semibold">
                        Rp {{ number_format($row->total, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="p-4 text-center text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50 border-t">
                <tr>
                    <td class="p-3 font-bold">TOTAL</td>
                    <td class="p-3 text-right font-bold">
                        Rp {{ number_format($data->sum('total'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- DETAIL TRANSAKSI --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 font-semibold border-b">Detail Transaksi</div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Waktu</th>
                    <th class="p-3 text-left">Order</th>
                    <th class="p-3 text-left">Metode</th>
                    <th class="p-3 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $pay)
                <tr class="border-t">
                    <td class="p-3">{{ $pay->paid_at->translatedFormat('l, d F Y') }}</td>
                    <td class="p-3">{{ $pay->paid_at->translatedFormat(' H:i') }}</td>
                    <td class="p-3">{{ $pay->order->order_code ?? '-' }}</td>
                    <td class="p-3 uppercase">{{ $pay->method }}</td>
                    <td class="p-3 text-right font-semibold">
                        Rp {{ number_format($pay->amount) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">
                        Tidak ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
