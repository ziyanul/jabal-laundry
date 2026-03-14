{{-- ========================= --}}
{{-- HALAMAN 1 : NOTA --}}
{{-- ========================= --}}
@include('orders.print')

<div style="page-break-after: always;"></div>

{{-- ========================= --}}
{{-- HALAMAN 2 : LABEL QR --}}
{{-- ========================= --}}
<div style="font-size:12px">
    <strong>{{ $order->order_code }}</strong><br>
    {{ $order->customer->name }}<br>

    Rak:
    @foreach ($order->orderRacks as $or)
        {{ $or->rack->code }}
    @endforeach

    <div style="margin-top:10px">
        {!! QrCode::size(80)->generate(route('orders.show', $order)) !!}
    </div>

    <small>Status: {{ strtoupper($order->status) }}</small>
</div>
