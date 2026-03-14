<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Laundry</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        .nota {
            width: 100%;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .total td {
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">
<div class="nota">

    {{-- HEADER --}}
    <div class="center">
        <div class="bold">{{ $order->outlet->name ?? 'Outlet Laundry' }}</div>
        <div>{{ $order->outlet->address ?? '-' }}</div>
        <div>Telp: {{ $order->outlet->phone ?? '-' }}</div>
    </div>

    <hr>

    {{-- INFO ORDER --}}
    <table>
        <tr>
            <td>Kode</td>
            <td>: {{ $order->order_code }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ $order->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>: {{ $order->customer->name ?? '-' }}</td>
        </tr>
    </table>

    <hr>

    {{-- DETAIL ITEM --}}
    <table>
        @foreach ($order->items as $item)
            <tr>
                <td colspan="2" class="bold">
                    {{ $item->service->name }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ $item->qty }} {{ $item->service->unit }}
                    x {{ number_format($item->price) }}
                </td>
                <td class="right">
                    {{ number_format($item->subtotal) }}
                </td>
            </tr>
        @endforeach
    </table>

    <hr>

    {{-- TOTAL --}}
    @php
    $paid  = $order->paid_amount ?? 0;
    $total = $order->total_price ?? 0;

    $change = $paid > $total ? $paid - $total : 0;
    $remaining = $paid < $total ? $total - $paid : 0;
@endphp

<table class="total">
    <tr>
        <td>Total</td>
        <td class="right">
            Rp {{ number_format($total) }}
        </td>
    </tr>
    <tr>
        <td>Bayar</td>
        <td class="right">
            Rp {{ number_format($paid) }}
        </td>
    </tr>

    @if($change > 0)
        <tr>
            <td>Kembali</td>
            <td class="right">
                Rp {{ number_format($change) }}
            </td>
        </tr>
    @elseif($remaining > 0)
        <tr>
            <td>Kurang Bayar</td>
            <td class="right">
                Rp {{ number_format($remaining) }}
            </td>
        </tr>
    @endif

    <tr>
        <td>Status</td>
        <td class="right">
            {{ strtoupper($order->payment_status) }}
        </td>
    </tr>
</table>

    <hr>

    {{-- FOOTER --}}
    <div class="center">
        <p>Terima kasih 🙏</p>
        <p>Simpan nota ini sebagai bukti</p>
    </div>

</div>
</body>
</html>
