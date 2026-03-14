@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4 max-w-3xl mx-auto">

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold">Master Service</h1>
        <a href="{{ route('services.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            + Tambah Service
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow divide-y">
@forelse($services as $service)
<div class="flex justify-between items-center p-4">
    <div>
        <p class="font-bold">{{ $service->name }}</p>
        <p class="text-sm text-gray-500">
            {{ strtoupper($service->unit) }} • 
            Rp {{ number_format($service->price) }} • 
            Volume: {{ $service->volume }}
        </p>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('services.edit', $service) }}"
           class="px-3 py-1 bg-yellow-500 text-white rounded">
            Edit
        </a>

        <form method="POST"
              action="{{ route('services.destroy', $service) }}"
              onsubmit="return confirm('Hapus service ini?')">
            @csrf
            @method('DELETE')
            <button class="px-3 py-1 bg-red-600 text-white rounded">
                Hapus
            </button>
        </form>
    </div>
</div>
@empty
<div class="p-4 text-center text-gray-500">
    Belum ada service
</div>
@endforelse
</div>


</div>
@endsection
