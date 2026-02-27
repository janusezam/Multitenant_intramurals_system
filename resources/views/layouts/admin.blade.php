<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Branding -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">🛡️</span>
                    <div>
                        <h1 class="text-xl font-bold text-white">ISMS Admin</h1>
                        <p class="text-xs text-gray-400">Super Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('admin.dashboard')) bg-red-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.universities.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('admin.universities.*')) bg-red-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                    <span>🏫</span>
                    <span>Universities</span>
                </a>

                <a href="{{ route('admin.subscriptions.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('admin.subscriptions.*')) bg-red-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                    <span>💳</span>
                    <span>Subscriptions</span>
                </a>
            </nav>

            <!-- Bottom User Section -->
            <div class="p-4 border-t border-gray-700 space-y-3">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Super Administrator</p>
                    <p class="font-semibold text-white mt-1">{{ auth()->user()->name }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="flex">
                    @csrf
                    <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors w-full text-left">
                        🚪 Logout
                    </button>
                </form>
            </div>

            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="absolute top-4 right-4 lg:hidden text-gray-400 hover:text-white">
                ✕
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0" @click="sidebarOpen = false" @click.self="sidebarOpen = false">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-4">
                        <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h2 class="text-xl font-semibold text-gray-900">@yield('title', 'Admin')</h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-sm font-medium px-3 py-1 rounded bg-red-100 text-red-800">
                            SUPER ADMIN
                        </span>

                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white bg-red-600">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mx-4 mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                        <span>✅</span>
                        <span class="text-green-800 text-sm">{{ session('success') }}</span>
                        <button @click="show = false" class="ml-auto text-green-600 hover:text-green-800">✕</button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mx-4 mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
                        <span>❌</span>
                        <span class="text-red-800 text-sm">{{ session('error') }}</span>
                        <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">✕</button>
                    </div>
                @endif

                @if($errors->any())
                    <div x-data="{ show: true }" x-show="show" class="mx-4 mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <span>❌</span>
                        <div class="flex-1">
                            <ul class="text-red-800 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-800">✕</button>
                    </div>
                @endif
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto">
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
