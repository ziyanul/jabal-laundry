@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4 max-w-3xl mx-auto">

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold">Master Rak</h1>

        <a href="{{ route('racks.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">
           + Tambah Rak
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow divide-y">
        @forelse($racks as $rack)
            <div class="flex justify-between items-center p-4">
                <div>
                    <p class="font-bold">{{ $rack->code }}</p>
                    <p class="text-sm text-gray-600">
                        Kapasitas: {{ $rack->capacity }} |
                        Status:
                        <span class="{{ $rack->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $rack->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('racks.edit', $rack) }}"
                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-sm">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('racks.destroy', $rack) }}">
                        @csrf
                        @method('DELETE')
                        <button
                            onclick="return confirm('Hapus rak ini?')"
                            class="px-3 py-1 bg-red-600 text-white rounded-lg text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-4 text-center text-gray-500">
                Belum ada data rak
            </div>
        @endforelse
    </div>

</div>
@endsection
