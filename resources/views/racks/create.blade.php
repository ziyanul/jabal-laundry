@extends('layouts.app')

@section('content')
<div class="p-4 max-w-xl mx-auto space-y-4">

    <h1 class="text-xl font-bold">Tambah Rak</h1>

    <form method="POST" action="{{ route('racks.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1">Kode Rak</label>
            <input
                type="text"
                name="code"
                class="w-full border rounded-lg p-2"
                placeholder="Contoh: RAK-A1"
                required>
        </div>

        <div>
            <label class="block text-sm mb-1">Kapasitas</label>
            <input
                type="number"
                name="capacity"
                class="w-full border rounded-lg p-2"
                placeholder="Jumlah maksimal order"
                required>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" checked>
            <span class="text-sm">Aktif</span>
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
            Simpan
        </button>
    </form>

</div>
@endsection
