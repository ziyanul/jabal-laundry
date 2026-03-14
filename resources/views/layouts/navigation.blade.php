<nav class="bg-white shadow mb-4">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-14 items-center">

            {{-- LEFT --}}
            <div class="flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="font-bold text-lg">
                    Jabal Laundry
                </a>

                <a href="{{ route('dashboard') }}"
                   class="text-sm {{ request()->routeIs('dashboard') ? 'font-semibold text-blue-600' : 'text-gray-600' }}">
                    Dashboard
                </a>

                <a href="{{ route('orders.index') }}"
                   class="text-sm text-gray-600">
                    Order
                </a>

                <a href="{{ route('customers.index') }}"
                   class="text-sm text-gray-600">
                    Customer
                </a>
            </div>

            {{-- RIGHT --}}
            <div class="flex items-center space-x-4 text-sm">
                <span class="text-gray-700">
                    {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
