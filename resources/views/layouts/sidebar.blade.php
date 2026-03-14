@php
$userRole = auth()->user()->role->name;
@endphp

<div class="flex flex-col w-64 min-h-screen bg-gray-800 text-white p-4">
    <div class="text-xl font-bold mb-4 md:block hidden">Jabal Laundry</div>

    <nav class="flex-1 overflow-y-auto space-y-2">

        <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>

        @if($userRole === 'admin')
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex justify-between items-center p-2 rounded hover:bg-gray-700">
                Master Data
                <svg :class="{'rotate-90': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="pl-4 mt-1 space-y-1">
                <a href="{{ route('customers.index') }}" class="block p-2 rounded hover:bg-gray-700">Customers</a>
                <a href="{{ route('services.index') }}" class="block p-2 rounded hover:bg-gray-700">Services</a>
                <a href="{{ route('racks.index') }}" class="block p-2 rounded hover:bg-gray-700">Racks</a>
                <a href="{{ route('outlets.index') }}" class="block p-2 rounded hover:bg-gray-700">Outlets</a>
                <a href="{{ route('users.index') }}" class="block py-1 px-2 hover:bg-gray-700 rounded">Karyawan</a>
            </div>
        </div>

        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open" class="w-full flex justify-between items-center p-2 rounded hover:bg-gray-700">
                Reports
                <svg :class="{'rotate-90': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="pl-4 mt-1 space-y-1">
                <a href="{{ route('reports.cash-daily') }}" class="block p-2 rounded hover:bg-gray-700">Cash Daily</a>
            </div>
        </div>
        @endif

        @if(in_array($userRole, ['admin','kasir']))
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open" class="w-full flex justify-between items-center p-2 rounded hover:bg-gray-700">
                Orders
                <svg :class="{'rotate-90': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="pl-4 mt-1 space-y-1">
                <a href="{{ route('orders.index') }}" class="block p-2 rounded hover:bg-gray-700">List Orders</a>
                <a href="{{ route('orders.create') }}" class="block p-2 rounded hover:bg-gray-700">Input Order</a>
            </div>
        </div>
        @endif

        @if(in_array($userRole, ['admin','kasir','karyawan']))
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open" class="w-full flex justify-between items-center p-2 rounded hover:bg-gray-700">
                Order Processing
                <svg :class="{'rotate-90': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
            <div x-show="open" class="pl-4 mt-1 space-y-1">
                <a href="{{ route('orders.index') }}" class="block p-2 rounded hover:bg-gray-700">Update Status</a>
            </div>
        </div>
        @endif

        <a href="{{ route('profile.edit') }}" class="block p-2 rounded hover:bg-gray-700 mt-4">Profil Saya</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full text-left p-2 rounded hover:bg-gray-700">Logout</button>
        </form>

    </nav>
</div>
