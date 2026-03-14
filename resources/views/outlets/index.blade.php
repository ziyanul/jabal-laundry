@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4 max-w-3xl mx-auto">

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold">Master Outlet</h1>
        <a href="{{ route('outlets.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            + Tambah Outlet
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow divide-y">
        @forelse($outlets as $outlet)
        <div class="p-4">
            <p class="font-bold">{{ $outlet->name }}</p>
            <p class="text-sm text-gray-500">{{ $outlet->phone }}</p>
            <p class="text-xs {{ $outlet->is_active ? 'text-green-600' : 'text-red-600' }}">
                {{ $outlet->is_active ? 'Aktif' : 'Nonaktif' }}
            </p>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500">
            Belum ada outlet
        </div>
        @endforelse
    </div>

</div>
@endsection
