<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Laundry</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar Desktop -->
        <div class="hidden md:flex md:flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        <!-- Mobile sidebar -->
        <div x-show="sidebarOpen" @click.away="sidebarOpen = false" class="fixed inset-0 flex z-40 md:hidden">
            <div class="fixed inset-0 bg-black bg-opacity-25"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800 text-white">
                @include('layouts.sidebar')
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Topbar -->
            <div class="md:hidden flex items-center justify-between bg-gray-800 text-white p-4">
                <button @click="sidebarOpen = true" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="font-bold text-lg">Jabal Laundry</div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
