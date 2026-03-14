@extends('layouts.app')

@section('content')
<div class="p-4 max-w-xl mx-auto space-y-4">

    <h1 class="text-xl font-bold">Tambah Service</h1>

    <form method="POST" action="{{ route('services.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm">Nama Service</label>
            <input name="name" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm">Unit</label>
            <select name="unit" class="w-full border rounded-lg p-2">
                <option value="kg">KG</option>
                <option value="pcs">PCS</option>
            </select>
        </div>

        <div>
            <label class="block text-sm">Harga</label>
            <input type="number" name="price" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
    <label class="block text-sm">Volume Rak / Unit</label>
    <input type="number"
           name="volume"
           class="w-full border rounded-lg p-2"
           required>
    <p class="text-xs text-gray-500 mt-1">
        Contoh: 1 kg = 10 kapasitas rak
    </p>
</div>


        <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
            Simpan
        </button>
    </form>

</div>
@endsection
