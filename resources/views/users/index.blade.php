@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4 space-y-4">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Daftar Karyawan</h1>
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah Karyawan
        </a>
    </div>

    <table class="w-full border rounded bg-white shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">Role</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">{{ $user->role->label ?? '-' }}</td>
                <td class="p-2">{{ ucfirst($user->status) }}</td>
                <td class="p-2 space-x-2">
                    <a href="{{ route('users.edit', $user) }}" class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500">Edit</a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center p-4 text-gray-500">Belum ada karyawan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
