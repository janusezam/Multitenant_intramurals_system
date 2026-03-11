<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 flex flex-col overflow-y-auto">

            <!-- Branding -->
            <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-800 flex-shrink-0">
                <div class="w-9 h-9 bg-red-500 rounded-xl flex items-center justify-center text-white text-lg flex-shrink-0">
                    👑
                </div>
                <div class="min-w-0">
                    <p class="text-white font-bold text-sm leading-tight">
                        ISMS Admin
                    </p>
                    <p class="text-slate-400 text-xs leading-tight truncate">
                        Administration
                    </p>
                </div>
            </div>

            <!-- Admin Badge -->
            <div class="px-4 py-3 border-b border-slate-800">
                <span class="inline-flex items-center w-full px-3 py-1.5 rounded-lg bg-red-950 text-red-300 text-xs font-medium truncate">
                    🛡️ SUPER ADMIN
                </span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('admin.dashboard')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.universities.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('admin.universities.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                    <span>🎓</span>
                    <span>Universities</span>
                </a>

                <a href="{{ route('admin.subscriptions.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors @if(request()->routeIs('admin.subscriptions.*')) bg-indigo-500 text-white font-medium @else text-slate-400 hover:bg-slate-800 hover:text-white @endif">
                    <span>💳</span>
                    <span>Subscriptions</span>
                </a>
            </nav>

            <!-- Bottom User Section -->
            <div class="mt-auto border-t border-slate-800 p-4 flex-shrink-0">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-white text-sm font-medium leading-tight truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-slate-400 text-xs leading-tight truncate">
                            Super Admin
                        </p>
                    </div>
                </div>
                <div class="space-y-1">
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
                        @yield('title', 'Admin Dashboard')
                    </h1>

                    <!-- Right: Badges + Avatar -->
                    <div class="flex items-center gap-3">
                        <!-- Admin badge -->
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                            🛡️ SUPER ADMIN
                        </span>

                        <!-- User avatar -->
                        <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white text-sm font-bold">
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
                    ISMS Admin © {{ date('Y') }}
                </p>
            </footer>

        </div>
    </div>
</body>
</html>
