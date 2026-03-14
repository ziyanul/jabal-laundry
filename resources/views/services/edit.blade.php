@extends('layouts.app')

@section('content')
<div class="p-4 max-w-xl mx-auto space-y-4">

    <h1 class="text-xl font-bold">Edit Service</h1>

    <form method="POST"
          action="{{ route('services.update', $service) }}"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm">Nama Service</label>
            <input name="name"
                   value="{{ old('name', $service->name) }}"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <div>
            <label class="block text-sm">Unit</label>
            <select name="unit" class="w-full border rounded-lg p-2">
                <option value="kg" {{ $service->unit=='kg'?'selected':'' }}>KG</option>
                <option value="pcs" {{ $service->unit=='pcs'?'selected':'' }}>PCS</option>
            </select>
        </div>

        <div>
            <label class="block text-sm">Harga</label>
            <input type="number"
                   name="price"
                   value="{{ old('price', $service->price) }}"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <div>
    <label class="block text-sm">Volume Rak / Unit</label>
    <input type="number"
           name="volume"
           value="{{ old('price', $service->volume) }}"
           class="w-full border rounded-lg p-2"
           required>
</div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
            Update
        </button>
    </form>

</div>
@endsection
