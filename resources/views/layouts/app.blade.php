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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
                        <!-- Plan badge modal wrapper -->
                        @if($university)
                        <div x-data="{ planModal: false }">
                            <!-- CLICKABLE PLAN BADGE -->
                            @if($university->plan === 'pro')
                            <button
                                x-on:click="planModal = true"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 hover:shadow-sm transition-all duration-200 group">
                                <span>⭐</span>
                                <span>PRO PLAN</span>
                                <svg class="w-3 h-3 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                            @else
                            <button
                                x-on:click="planModal = true"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 hover:shadow-sm transition-all duration-200 group">
                                <span>📋</span>
                                <span>BASIC PLAN</span>
                                <svg class="w-3 h-3 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                            @endif

                            <!-- MODAL OVERLAY -->
                            <div
                                x-show="planModal"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                                style="display:none">

                                <!-- BACKDROP -->
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" x-on:click="planModal = false">
                                </div>

                                <!-- MODAL BOX -->
                                <div
                                    x-show="planModal"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    x-on:click.stop
                                    class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden z-10">

                                    <!-- MODAL HEADER -->
                                    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-8">

                                        <!-- BG decorations -->
                                        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none">
                                        </div>
                                        <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-purple-500/10 blur-2xl pointer-events-none">
                                        </div>

                                        <!-- Close button -->
                                        <button x-on:click="planModal = false"
                                            class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors z-10">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>

                                        <!-- Header content -->
                                        <div class="relative z-10">
                                            <!-- University name -->
                                            <p class="text-indigo-300 text-xs font-medium uppercase tracking-widest mb-2">
                                                {{ $university->name }}
                                            </p>

                                            <!-- Title -->
                                            <h2 class="text-2xl font-bold text-white mb-1">
                                                Subscription Plan
                                            </h2>
                                            <p class="text-slate-400 text-sm">
                                                Manage and view your current ISMS subscription details
                                            </p>

                                            <!-- Current plan pill + expiry -->
                                            <div class="flex flex-wrap items-center gap-3 mt-4">

                                                @if($university->plan === 'pro')
                                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/20 border border-amber-500/30">
                                                    <span class="text-lg">⭐</span>
                                                    <div>
                                                        <p class="text-amber-300 text-xs font-medium uppercase tracking-wide">
                                                            Current Plan
                                                        </p>
                                                        <p class="text-white font-bold text-base leading-none">
                                                            Pro Plan
                                                        </p>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-500/20 border border-slate-500/30">
                                                    <span class="text-lg">📋</span>
                                                    <div>
                                                        <p class="text-slate-300 text-xs font-medium uppercase tracking-wide">
                                                            Current Plan
                                                        </p>
                                                        <p class="text-white font-bold text-base leading-none">
                                                            Basic Plan
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($university->plan_expires_at)
                                                @php
                                                    $expires = $university->plan_expires_at;
                                                    $daysLeft = (int) now()->diffInDays($expires, false);
                                                @endphp
                                                <div class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white/10 border border-white/10">
                                                    <svg class="w-4 h-4 {{ $daysLeft <= 30 ? 'text-red-400' : 'text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <div>
                                                        <p class="text-slate-400 text-xs">
                                                            @if($daysLeft > 0)
                                                                Expires {{ $expires->format('M d, Y') }}
                                                            @else
                                                                Plan Expired
                                                            @endif
                                                        </p>
                                                        <p class="text-xs font-semibold {{ $daysLeft <= 30 ? 'text-red-400' : 'text-emerald-400' }}">
                                                            @if($daysLeft > 0)
                                                                {{ $daysLeft }} days remaining
                                                            @else
                                                                Please renew
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Active status -->
                                                <div class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-500/20 border border-emerald-500/30">
                                                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse">
                                                    </div>
                                                    <span class="text-emerald-400 text-xs font-medium">
                                                        Active
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL BODY -->
                                    <div class="p-6 overflow-y-auto max-h-[60vh]">

                                        <!-- PLAN COMPARISON -->
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-4">
                                            Plan Comparison
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                                            <!-- BASIC PLAN -->
                                            <div class="relative rounded-xl border-2 p-5 {{ $university->plan === 'basic' ? 'border-indigo-400 bg-indigo-50/50' : 'border-slate-200 bg-slate-50/50' }}">

                                                @if($university->plan === 'basic')
                                                <!-- Current plan indicator -->
                                                <div class="absolute -top-3 left-4">
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-indigo-500 text-white text-xs font-semibold rounded-full shadow-sm">
                                                        ✓ Your Plan
                                                    </span>
                                                </div>
                                                @endif

                                                <!-- Plan header -->
                                                <div class="mb-4 pt-1">
                                                    <h4 class="text-lg font-bold text-slate-900">
                                                        Basic
                                                    </h4>
                                                    <p class="text-slate-500 text-xs mt-0.5">
                                                        Perfect for getting started
                                                    </p>
                                                </div>

                                                <!-- Limits -->
                                                <div class="grid grid-cols-2 gap-2 mb-4">
                                                    @php
                                                    $basicLimits = [
                                                        ['5', 'Sports'],
                                                        ['10', 'Teams/Sport'],
                                                        ['200', 'Players'],
                                                        ['50', 'Users'],
                                                    ];
                                                    @endphp
                                                    @foreach($basicLimits as $limit)
                                                    <div class="bg-white rounded-lg border border-slate-200 p-2 text-center">
                                                        <p class="text-base font-bold text-slate-900">
                                                            {{ $limit[0] }}
                                                        </p>
                                                        <p class="text-xs text-slate-500">
                                                            {{ $limit[1] }}
                                                        </p>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <!-- Features -->
                                                <ul class="space-y-2">
                                                    @php
                                                    $basicFeatures = [
                                                        [true,  'Game Scheduling'],
                                                        [true,  'Live Standings'],
                                                        [true,  'Match Results'],
                                                        [true,  'Venue Management'],
                                                        [true,  'Team & Player Registry'],
                                                        [true,  'Role-Based Access'],
                                                        [false, 'Analytics Dashboard'],
                                                        [false, 'PDF / Excel Export'],
                                                        [false, 'Bracket Generator'],
                                                        [false, 'Unlimited Resources'],
                                                        [false, 'Priority Support'],
                                                    ];
                                                    @endphp
                                                    @foreach($basicFeatures as $f)
                                                    <li class="flex items-center gap-2.5 text-sm">
                                                        @if($f[0])
                                                        <div class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-2.5 h-2.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </div>
                                                        <span class="text-slate-700">
                                                            {{ $f[1] }}
                                                        </span>
                                                        @else
                                                        <div class="w-4 h-4 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-2.5 h-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </div>
                                                        <span class="text-slate-400 line-through">
                                                            {{ $f[1] }}
                                                        </span>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <!-- PRO PLAN -->
                                            <div class="relative rounded-xl border-2 p-5 {{ $university->plan === 'pro' ? 'border-amber-400 bg-amber-50/50' : 'border-slate-200 bg-white' }}">

                                                @if($university->plan === 'pro')
                                                <!-- Current plan indicator -->
                                                <div class="absolute -top-3 left-4">
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-500 text-white text-xs font-semibold rounded-full shadow-sm">
                                                        ⭐ Your Plan
                                                    </span>
                                                </div>
                                                @endif

                                                <!-- Plan header -->
                                                <div class="mb-4 pt-1">
                                                    <h4 class="text-lg font-bold text-slate-900 flex items-center gap-1.5">
                                                        Pro
                                                        <span class="text-amber-500">⭐</span>
                                                    </h4>
                                                    <p class="text-slate-500 text-xs mt-0.5">
                                                        Full power for serious universities
                                                    </p>
                                                </div>

                                                <!-- Limits -->
                                                <div class="grid grid-cols-2 gap-2 mb-4">
                                                    @php
                                                    $proLimits = [
                                                        ['∞', 'Sports'],
                                                        ['∞', 'Teams/Sport'],
                                                        ['∞', 'Players'],
                                                        ['∞', 'Users'],
                                                    ];
                                                    @endphp
                                                    @foreach($proLimits as $limit)
                                                    <div class="bg-amber-50 rounded-lg border border-amber-200 p-2 text-center">
                                                        <p class="text-base font-bold text-amber-700">
                                                            {{ $limit[0] }}
                                                        </p>
                                                        <p class="text-xs text-amber-600">
                                                            {{ $limit[1] }}
                                                        </p>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <!-- Features -->
                                                <ul class="space-y-2">
                                                    @php
                                                    $proFeatures = [
                                                        [true,  false, 'Game Scheduling'],
                                                        [true,  false, 'Live Standings'],
                                                        [true,  false, 'Match Results'],
                                                        [true,  false, 'Venue Management'],
                                                        [true,  false, 'Team & Player Registry'],
                                                        [true,  false, 'Role-Based Access'],
                                                        [true,  true,  'Analytics Dashboard'],
                                                        [true,  true,  'PDF / Excel Export'],
                                                        [true,  true,  'Bracket Generator'],
                                                        [true,  true,  'Unlimited Resources'],
                                                        [true,  true,  'Priority Support'],
                                                    ];
                                                    @endphp
                                                    @foreach($proFeatures as $f)
                                                    <li class="flex items-center gap-2.5 text-sm">
                                                        @if($f[1])
                                                        <!-- Pro exclusive feature -->
                                                        <div class="w-4 h-4 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-2.5 h-2.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </div>
                                                        <span class="text-amber-700 font-medium">
                                                            {{ $f[2] }}
                                                        </span>
                                                        <span class="ml-auto text-xs bg-amber-100 text-amber-600 px-1.5 py-0.5 rounded-full">
                                                            PRO
                                                        </span>
                                                        @else
                                                        <!-- Standard feature -->
                                                        <div class="w-4 h-4 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-2.5 h-2.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </div>
                                                        <span class="text-slate-700">
                                                            {{ $f[2] }}
                                                        </span>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- USAGE STATS (Basic plan only) -->
                                        @if($university->plan === 'basic')
                                        @php
                                            $sportsUsed = \App\Models\Sport::count();
                                            $playersUsed = \App\Models\Player::count();
                                            $usersUsed = \App\Models\User::withoutGlobalScopes()->where('university_id', $university->id)->count();
                                        @endphp
                                        <div class="bg-slate-50 rounded-xl border border-slate-200 p-5 mb-4">
                                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-4">
                                                📊 Your Usage
                                            </h4>
                                            <div class="space-y-3">

                                                @php
                                                $usageItems = [
                                                    ['Sports',  $sportsUsed,  5,   'indigo'],
                                                    ['Players', $playersUsed, 200, 'blue'],
                                                    ['Users',   $usersUsed,   50,  'purple'],
                                                ];
                                                @endphp

                                                @foreach($usageItems as $item)
                                                @php
                                                    $pct = min(($item[1]/$item[2])*100, 100);
                                                    $isRed = $pct >= 100;
                                                    $isAmber = $pct >= 80 && $pct < 100;
                                                @endphp
                                                <div>
                                                    <div class="flex items-center justify-between mb-1.5">
                                                        <span class="text-sm text-slate-600">
                                                            {{ $item[0] }}
                                                        </span>
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-sm font-semibold {{ $isRed ? 'text-red-600' : ($isAmber ? 'text-amber-600' : 'text-slate-700') }}">
                                                                {{ $item[1] }} / {{ $item[2] }}
                                                            </span>
                                                            @if($isRed)
                                                            <span class="text-xs px-1.5 py-0.5 bg-red-100 text-red-600 rounded-full font-medium">
                                                                Limit Reached
                                                            </span>
                                                            @elseif($isAmber)
                                                            <span class="text-xs px-1.5 py-0.5 bg-amber-100 text-amber-600 rounded-full font-medium">
                                                                Almost Full
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                                        <div class="h-2 rounded-full transition-all duration-500 {{ $isRed ? 'bg-red-500' : ($isAmber ? 'bg-amber-500' : 'bg-'.$item[3].'-500') }}" style="width: {{ $pct }}%">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- UPGRADE CTA -->
                                        <div class="relative overflow-hidden rounded-xl p-5 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700">
                                            <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-white/5 blur-xl pointer-events-none">
                                            </div>
                                            <div class="relative z-10 flex items-center justify-between gap-4">
                                                <div>
                                                    <p class="text-white font-bold text-base">
                                                        Unlock Pro Features ⭐
                                                    </p>
                                                    <p class="text-indigo-200 text-sm mt-1">
                                                        Get Analytics, Bracket Generator, unlimited resources and more.
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0 text-center">
                                                    <p class="text-indigo-200 text-xs mb-2">
                                                        Contact Super Admin
                                                    </p>
                                                    <div class="inline-flex items-center gap-1.5 px-4 py-2 bg-white rounded-lg text-indigo-600 text-sm font-bold shadow-lg">
                                                        ⭐ Upgrade to Pro
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- PRO ACTIVE MESSAGE -->
                                        @if($university->plan === 'pro')
                                        <div class="relative overflow-hidden rounded-xl p-5 bg-gradient-to-r from-amber-500 to-orange-500">
                                            <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-white/10 blur-xl pointer-events-none">
                                            </div>
                                            <div class="relative z-10 flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0 text-2xl">
                                                    🏆
                                                </div>
                                                <div>
                                                    <p class="text-white font-bold text-base">
                                                        You have full Pro access!
                                                    </p>
                                                    <p class="text-amber-100 text-sm mt-0.5">
                                                        All features are unlocked including Analytics, Brackets, and unlimited resources for your university.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <!-- CLOSE BUTTON -->
                                        <button x-on:click="planModal = false"
                                            class="w-full mt-4 border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 text-sm font-medium px-4 py-2.5 rounded-xl transition-colors">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
