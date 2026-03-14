@extends('layouts.app')

@section('content')
<div class="p-4 max-w-xl mx-auto space-y-4">

    <h1 class="text-xl font-bold">Tambah Customer</h1>

    <form method="POST" action="{{ route('customers.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm">Nama</label>
            <input name="name" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm">No. HP / WhatsApp</label>
            <input name="phone" class="w-full border rounded-lg p-2">
        </div>

        <div>
            <label class="block text-sm">Alamat (opsional)</label>
            <textarea name="address" class="w-full border rounded-lg p-2"></textarea>
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
            Simpan
        </button>
    </form>

</div>
@endsection
