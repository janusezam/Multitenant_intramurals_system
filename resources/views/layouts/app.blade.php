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
<body class="bg-slate-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 flex flex-col overflow-y-auto">

            <!-- Branding -->
            <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-800 flex-shrink-0">
                <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center text-white text-lg flex-shrink-0">
                    🏆
                </div>
                <div class="min-w-0">
                    <p class="text-white font-bold text-sm leading-tight">
                        ISMS
                    </p>
                    <p class="text-slate-400 text-xs leading-tight truncate">
                        Intramurals Management
                    </p>
                </div>
            </div>

            <!-- University Badge -->
            @if($university)
                <div class="px-4 py-3 border-b border-slate-800">
                    <span class="inline-flex items-center w-full px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 text-xs font-medium truncate">
                        🏫 {{ $university->name }}
                    </span>
                </div>
            @endif

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1">
                @if($university)
                    @php
                        $user = auth()->user();
                    @endphp

                    <!-- UNIVERSITY ADMIN - Full Access -->
                    @if($user->hasRole('university-admin'))
                        <a href="{{ route('tenant.dashboard', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.dashboard')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏠</span>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('tenant.sports.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.sports.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏅</span>
                            <span>Sports</span>
                        </a>

                        <a href="{{ route('tenant.venues.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.venues.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏟️</span>
                            <span>Venues</span>
                        </a>

                        <a href="{{ route('tenant.teams.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.teams.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>👥</span>
                            <span>Teams</span>
                        </a>

                        <a href="{{ route('tenant.players.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.players.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🎽</span>
                            <span>Players</span>
                        </a>

                        <a href="{{ route('tenant.schedules.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.schedules.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>📅</span>
                            <span>Schedules</span>
                        </a>

                        <a href="{{ route('tenant.standings.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.standings.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏆</span>
                            <span>Standings</span>
                        </a>

                        @if($university->plan === 'pro')
                            <div class="my-4 pt-3 border-t border-slate-800">
                                <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-500">Pro Features</p>

                                <a href="{{ route('tenant.analytics.index', $university->slug) }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.analytics.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                                    <span>📊</span>
                                    <span>Analytics</span>
                                    <span class="ml-auto text-xs bg-amber-500/20 text-amber-300 rounded-full px-1.5 py-0.5">PRO</span>
                                </a>

                                <a href="{{ route('tenant.brackets.index', $university->slug) }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.brackets.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                                    <span>🎯</span>
                                    <span>Brackets</span>
                                    <span class="ml-auto text-xs bg-amber-500/20 text-amber-300 rounded-full px-1.5 py-0.5">PRO</span>
                                </a>
                            </div>
                        @endif
                    @endif

                    <!-- SPORTS FACILITATOR - Sport Management -->
                    @if($user->hasRole('sports-facilitator'))
                        <a href="{{ route('tenant.dashboard', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.dashboard')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏠</span>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('tenant.sports.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.sports.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏅</span>
                            <span>My Sport</span>
                        </a>

                        <a href="{{ route('tenant.teams.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.teams.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>👥</span>
                            <span>Teams</span>
                        </a>

                        <a href="{{ route('tenant.players.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.players.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🎽</span>
                            <span>Players</span>
                        </a>

                        <a href="{{ route('tenant.schedules.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.schedules.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>📅</span>
                            <span>Schedules</span>
                        </a>

                        <a href="{{ route('tenant.standings.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.standings.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏆</span>
                            <span>Standings</span>
                        </a>

                        @if($university->plan === 'pro')
                            <div class="my-4 pt-3 border-t border-slate-800">
                                <a href="{{ route('tenant.brackets.index', $university->slug) }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.brackets.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                                    <span>🎯</span>
                                    <span>Brackets</span>
                                    <span class="ml-auto text-xs bg-amber-500/20 text-amber-300 rounded-full px-1.5 py-0.5">PRO</span>
                                </a>
                            </div>
                        @endif
                    @endif

                    <!-- TEAM COACH - Team Management -->
                    @if($user->hasRole('team-coach'))
                        <a href="{{ route('tenant.dashboard', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.dashboard')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏠</span>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('tenant.teams.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.teams.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>👥</span>
                            <span>My Team</span>
                        </a>

                        <a href="{{ route('tenant.players.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.players.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🎽</span>
                            <span>My Players</span>
                        </a>

                        <a href="{{ route('tenant.schedules.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.schedules.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>📅</span>
                            <span>My Schedule</span>
                        </a>

                        <a href="{{ route('tenant.standings.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.standings.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏆</span>
                            <span>Standings</span>
                        </a>
                    @endif

                    <!-- STUDENT PLAYER - Read-Only Views -->
                    @if($user->hasRole('student-player'))
                        <a href="{{ route('tenant.dashboard', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.dashboard')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏠</span>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('tenant.standings.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.standings.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>🏆</span>
                            <span>Standings</span>
                        </a>

                        <a href="{{ route('tenant.schedules.index', $university->slug) }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('tenant.schedules.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                            <span>📅</span>
                            <span>Game Schedule</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('home')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                        <span>🏠</span>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('profile.edit')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                        <span>👤</span>
                        <span>Profile</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom User Section -->
            <div class="mt-auto border-t border-slate-800 p-4 flex-shrink-0">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white text-sm font-medium leading-tight truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-slate-400 text-xs leading-tight truncate">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </p>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="@if($university){{ route('tenant.profile.edit', $university->slug) }}@else{{ route('profile.edit') }}@endif"
                       class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white text-xs transition-colors w-full">
                        👤 Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-red-400 text-xs transition-colors w-full text-left">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content: offset exactly by sidebar width -->
        <div class="flex flex-col flex-1 ml-64 min-w-0">

            <!-- Topbar -->
            <header class="sticky top-0 z-40 bg-white border-b border-slate-200 flex-shrink-0">
                <div class="flex items-center justify-between h-16 px-6">
                    <!-- Left: Page title -->
                    <h1 class="text-lg font-semibold text-slate-900">
                        @yield('title', 'Dashboard')
                    </h1>

                    <!-- Right: Badges + Avatar -->
                    <div class="flex items-center gap-3">
                        <!-- Plan badge -->
                        @if($university)
                            @if($university->plan === 'pro')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                    ⭐ PRO PLAN
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    BASIC PLAN
                                </span>
                            @endif
                        @endif

                        <!-- User avatar -->
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <div class="px-6 pt-4 space-y-2">
                @if(session('success'))
                    <div class="flex items-center gap-3 bg-emerald-50 border-l-4 border-emerald-500 border border-emerald-200 rounded-xl p-4 text-sm text-emerald-800"
                         x-data="{ show: true }"
                         x-show="show">
                        <span class="flex-1">
                            ✅ {{ session('success') }}
                        </span>
                        <button x-on:click="show = false"
                                class="text-emerald-600 hover:text-emerald-800 font-bold text-lg leading-none">
                            ×
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center gap-3 bg-red-50 border-l-4 border-red-500 border border-red-200 rounded-xl p-4 text-sm text-red-800"
                         x-data="{ show: true }"
                         x-show="show">
                        <span class="flex-1">
                            ❌ {{ session('error') }}
                        </span>
                        <button x-on:click="show = false"
                                class="text-red-600 hover:text-red-800 font-bold text-lg leading-none">
                            ×
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="flex items-center gap-3 bg-red-50 border-l-4 border-red-500 border border-red-200 rounded-xl p-4 text-sm text-red-800"
                         x-data="{ show: true }"
                         x-show="show">
                        <span class="flex-1">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </span>
                        <button x-on:click="show = false"
                                class="text-red-600 hover:text-red-800 font-bold text-lg leading-none flex-shrink-0">
                            ×
                        </button>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="flex-shrink-0 border-t border-slate-100 bg-white px-6 py-3">
                <p class="text-xs text-slate-400 text-center">
                    ISMS © {{ date('Y') }}@if($university) · {{ $university->name }}@endif
                </p>
            </footer>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
