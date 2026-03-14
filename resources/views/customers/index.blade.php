@extends('layouts.app')

@section('content')
<div class="p-4 space-y-4 max-w-3xl mx-auto">

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold">Master Customer</h1>
        <a href="{{ route('customers.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            + Tambah Customer
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow divide-y">
        @forelse($customers as $customer)
        <div class="p-4">
            <p class="font-bold">{{ $customer->name }}</p>
            <p class="text-sm text-gray-500">
                {{ $customer->phone ?? '-' }}
            </p>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500">
            Belum ada customer
        </div>
        @endforelse
    </div>

</div>
@endsection
