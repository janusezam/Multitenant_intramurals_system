@php
$university = app()->has('current_university') ? app('current_university') : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                    <span class="text-2xl">🏆</span>
                    <div>
                        <h1 class="text-xl font-bold text-white">ISMS</h1>
                        <p class="text-xs text-gray-400">Intramurals Management</p>
                    </div>
                </div>
                @if($university)
                    <span class="inline-block bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                        {{ $university->name }}
                    </span>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                @if($university)
                    <a href="{{ route('tenant.dashboard', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.dashboard')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>🏠</span>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('tenant.sports.index', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.sports.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>🏅</span>
                        <span>Sports</span>
                    </a>

                    <a href="{{ route('tenant.venues.index', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.venues.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>🏟️</span>
                        <span>Venues</span>
                    </a>

                    <a href="{{ route('tenant.teams.index', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.teams.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>👥</span>
                        <span>Teams</span>
                    </a>

                    <a href="{{ route('tenant.players.index', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.players.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>🎽</span>
                        <span>Players</span>
                    </a>

                    <a href="{{ route('tenant.schedules.index', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.schedules.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>📅</span>
                        <span>Schedules</span>
                    </a>

                    <a href="{{ route('tenant.standings.index', $university->slug) }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.standings.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>🏆</span>
                        <span>Standings</span>
                    </a>

                    @if($university->plan === 'pro')
                        <div class="my-4 pt-4 border-t border-gray-700">
                            <p class="px-4 text-xs uppercase tracking-wide text-gray-500 font-semibold">Pro Features</p>

                            <a href="{{ route('tenant.analytics.index', $university->slug) }}"
                                class="flex items-center gap-3 px-4 py-2 mt-2 rounded transition-colors @if(request()->routeIs('tenant.analytics.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                                <span>📊</span>
                                <span>Analytics</span>
                                <span class="ml-auto text-xs bg-yellow-600 text-white px-2 py-0.5 rounded">PRO</span>
                            </a>

                            <a href="{{ route('tenant.brackets.index', $university->slug) }}"
                                class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('tenant.brackets.*')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                                <span>🎯</span>
                                <span>Brackets</span>
                                <span class="ml-auto text-xs bg-yellow-600 text-white px-2 py-0.5 rounded">PRO</span>
                            </a>
                        </div>
                    @endif
                @else
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('home')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>🏠</span>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded transition-colors @if(request()->routeIs('profile.edit')) bg-indigo-600 text-white @else text-gray-300 hover:bg-gray-800 hover:text-white @endif">
                        <span>👤</span>
                        <span>Profile</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom User Section -->
            <div class="p-4 border-t border-gray-700 space-y-3">
                <div>
                    <p class="font-semibold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ auth()->user()->getRoleNames()->first() }}</p>
                </div>

                <a href="@if($university){{ route('tenant.profile.edit', $university->slug) }}@else{{ route('profile.edit') }}@endif" class="block text-sm text-gray-300 hover:text-white transition-colors">
                    👤 Edit Profile
                </a>

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
                        <h2 class="text-xl font-semibold text-gray-900">@yield('title', 'Dashboard')</h2>
                    </div>

                    <div class="flex items-center gap-4">
                        @if($university)
                            <span class="text-sm font-medium px-3 py-1 rounded @if($university->plan === 'pro') bg-yellow-100 text-yellow-800 @else bg-gray-200 text-gray-800 @endif">
                                @if($university->plan === 'pro')
                                    PRO PLAN ⭐
                                @else
                                    BASIC PLAN
                                @endif
                            </span>
                        @endif

                        <button class="text-gray-600 hover:text-gray-900">
                            🔔
                        </button>

                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white bg-indigo-600">
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

                    <!-- Footer -->
                    <footer class="mt-12 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                        ISMS © {{ date('Y') }}@if($university) · {{ $university->name }}@endif
                    </footer>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
