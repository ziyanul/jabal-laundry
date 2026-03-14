@extends('layouts.app')

@section('content')
<div class="p-4 space-y-6 max-w-xl mx-auto">

    <h1 class="text-xl font-bold">Order Baru</h1>

    <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- CUSTOMER --}}
        <div class="space-y-2">
            <div>
                <label class="text-sm font-medium">Nama Customer</label>
                <input name="customer_name" class="w-full border rounded-lg p-2" required>
            </div>

            <div>
                <label class="text-sm font-medium">No HP</label>
                <input name="customer_phone" class="w-full border rounded-lg p-2">
            </div>
        </div>

        <hr>

        {{-- SERVICES --}}
        <div class="space-y-3">
            <h2 class="font-semibold">Layanan</h2>

            @foreach ($services as $service)
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $service->name }}</p>
                        <p class="text-sm text-gray-500">
                            Rp {{ number_format($service->price) }} / {{ $service->unit }}
                        </p>
                    </div>

                    <input
                        type="number"
                        step="0.1"
                        min="0"
                        data-price="{{ $service->price }}"
                        class="service-qty w-24 border rounded p-1 text-right"
                        name="services[{{ $service->uuid }}]">
                </div>
            @endforeach
        </div>

        {{-- TOTAL --}}
        <div class="bg-gray-100 rounded-lg p-3 flex justify-between font-semibold">
            <span>Total</span>
            <span>Rp <span id="totalText">0</span></span>
        </div>

        <input type="hidden" name="total_price" id="totalInput">

        {{-- BAYAR --}}
        <div>
            <label class="text-sm font-medium">Bayar</label>
            <input
                type="number"
                name="payment_amount"
                id="paymentInput"
                class="w-full border rounded-lg p-2"
                placeholder="0">
        </div>

        {{-- KURANG BAYAR --}}
        <div id="remainingBox" class="flex justify-between text-red-600 hidden">
            <span>Kurang Bayar</span>
            <span>Rp <span id="remainingText">0</span></span>
        </div>

        {{-- KEMBALIAN --}}
        <div id="changeBox" class="flex justify-between text-green-600 hidden">
            <span>Kembalian</span>
            <span>Rp <span id="changeText">0</span></span>
        </div>

        {{-- METODE --}}
        <div>
            <label class="text-sm font-medium">Metode Pembayaran</label>
            <select name="payment_method" class="w-full border rounded-lg p-2">
                <option value="">-</option>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
            Simpan Order
        </button>
    </form>
</div>

<script>
const qtyInputs = document.querySelectorAll('.service-qty');
const payInput = document.getElementById('paymentInput');

const totalText = document.getElementById('totalText');
const remainingText = document.getElementById('remainingText');
const changeText = document.getElementById('changeText');

const remainingBox = document.getElementById('remainingBox');
const changeBox = document.getElementById('changeBox');

const totalInput = document.getElementById('totalInput');

function hitung() {
    let total = 0;

    qtyInputs.forEach(input => {
        const qty = parseFloat(input.value) || 0;
        const price = parseFloat(input.dataset.price) || 0;
        total += qty * price;
    });

    const paid = parseInt(payInput.value) || 0;

    totalText.innerText = total.toLocaleString('id-ID');
    totalInput.value = total;

    remainingBox.classList.add('hidden');
    changeBox.classList.add('hidden');

    if (paid > 0) {
        if (paid < total) {
            remainingText.innerText = (total - paid).toLocaleString('id-ID');
            remainingBox.classList.remove('hidden');
        } else if (paid > total) {
            changeText.innerText = (paid - total).toLocaleString('id-ID');
            changeBox.classList.remove('hidden');
        }
    }
}

qtyInputs.forEach(i => i.addEventListener('input', hitung));
payInput.addEventListener('input', hitung);

hitung();
</script>
@endsection
