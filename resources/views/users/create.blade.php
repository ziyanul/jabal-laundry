@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 bg-white rounded shadow">

    <h1 class="text-xl font-bold mb-4">{{ isset($user) ? 'Edit Karyawan' : 'Tambah Karyawan' }}</h1>

    <form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="block font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" 
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-3">
            <label class="block font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-3">
            <label class="block font-medium mb-1">Role</label>
            <select name="role_uuid" class="w-full border rounded px-3 py-2">
                @foreach($roles as $role)
                    <option value="{{ $role->uuid }}" {{ (isset($user) && $user->role_uuid === $role->uuid) ? 'selected' : '' }}>
                        {{ $role->label }}
                    </option>
                @endforeach
            </select>
        </div>

        @if(!isset($user))
        <div class="mb-3">
            <label class="block font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
        </div>
        @endif

        <div class="flex justify-end space-x-2">
            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded bg-gray-400 hover:bg-gray-500 text-white">Batal</a>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                {{ isset($user) ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
</div>
@endsection
