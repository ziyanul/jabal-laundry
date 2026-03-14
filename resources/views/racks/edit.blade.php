@extends('layouts.app')

@section('content')
<div class="p-4 max-w-xl mx-auto space-y-4">

    <h1 class="text-xl font-bold">Edit Rak</h1>

    <form method="POST"
          action="{{ route('racks.update', $rack) }}"
          class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm mb-1">Kode Rak</label>
            <input type="text"
                   name="code"
                   value="{{ old('code', $rack->code) }}"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <div>
            <label class="block text-sm mb-1">Kapasitas</label>
            <input type="number"
                   name="capacity"
                   value="{{ old('capacity', $rack->capacity) }}"
                   class="w-full border rounded-lg p-2"
                   required>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   {{ $rack->is_active ? 'checked' : '' }}>
            <span class="text-sm">Aktif</span>
        </div>

        <button class="w-full bg-blue-600 text-white py-3 rounded-lg">
            Update
        </button>
    </form>

</div>
@endsection
