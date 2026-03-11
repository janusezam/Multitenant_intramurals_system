@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Welcome back, {{ auth()->user()->name }} 👋</h1>
                <p class="text-slate-600 mt-2">University Admin</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🏅</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                    {{ $stats['total_sports'] }}
                </p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                    Total Sports
                </p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">👥</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                    {{ $stats['total_teams'] }}
                </p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                    Total Teams
                </p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🎽</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                    {{ $stats['total_players'] }}
                </p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                    Total Players
                </p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🏟️</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                    {{ $stats['total_venues'] }}
                </p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                    Total Venues
                </p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">📅</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                    {{ $stats['upcoming_schedules'] }}
                </p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                    Upcoming Games
                </p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🔴</span>
                    </div>
                </div>
                <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                    {{ $stats['ongoing_sports'] }}
                </p>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                    Ongoing Sports
                </p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-4">Quick Actions</h2>
            <div class="flex flex-wrap gap-3">
                @can('create', App\Models\Sport::class)
                    <a href="{{ route('tenant.sports.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        ➕ Add Sport
                    </a>
                @endcan
                @can('create', App\Models\Team::class)
                    <a href="{{ route('tenant.teams.create', $university->slug) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        ➕ Add Team
                    </a>
                @endcan
                @can('create', App\Models\Schedule::class)
                    <a href="{{ route('tenant.schedules.create', $university->slug) }}" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 transition">
                        📅 Schedule Game
                    </a>
                @endcan
                @can('viewAny', App\Models\Standing::class)
                    <a href="{{ route('tenant.standings.index', $university->slug) }}" class="px-4 py-2 bg-slate-600 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition">
                        🏅 View Standings
                    </a>
                @endcan
            </div>
        </div>

        <!-- Sports Overview -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-6">Sports Overview</h2>

            @if($sports->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($sports as $sport)
                        <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-sm font-semibold text-slate-900">{{ $sport->name }}</h3>
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                    $sport->status === 'ongoing' ? 'bg-green-50 text-green-700' :
                                    ($sport->status === 'completed' ? 'bg-slate-100 text-slate-600' : 'bg-blue-50 text-blue-700')
                                }}">
                                    {{ ucfirst($sport->status) }}
                                </span>
                            </div>
                            <div class="space-y-2 text-xs text-slate-600 mb-4">
                                <p>📋 Category: {{ $sport->category ?? 'N/A' }}</p>
                                <p>👥 Teams: {{ $sport->teams_count }}</p>
                                <p>⚽ Players: {{ $sport->players_count }}</p>
                                <p>📅 Schedules: {{ $sport->schedules_count }}</p>
                            </div>
                            <a href="{{ route('tenant.sports.show', [$university->slug, $sport]) }}" class="text-indigo-600 text-xs font-medium hover:text-indigo-700">
                                Manage →
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-slate-500">
                    <p class="mb-2">No sports created yet</p>
                </div>
            @endif
        </div>

        <!-- Upcoming Schedules -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-6">Upcoming Schedules</h2>

            @if($upcomingSchedules->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Sport</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Match</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Venue</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date & Time</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($upcomingSchedules as $schedule)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-slate-900 font-medium">{{ $schedule->sport->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-900">
                                        {{ $schedule->homeTeam->name ?? 'N/A' }} vs {{ $schedule->awayTeam->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">{{ $schedule->venue->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $schedule->scheduled_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-slate-500">
                    <p>No upcoming schedules</p>
                </div>
            @endif
        </div>

        <!-- Standings Summary -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-6">Standings Summary</h2>

            @if($standings->count() > 0)
                <div class="space-y-6">
                    @foreach($standings as $sportId => $sportStandings)
                        @php
                            $sport = $sports->where('id', $sportId)->first();
                        @endphp
                        @if($sport)
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900 mb-3">{{ $sport->name }}</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-slate-200 bg-slate-50">
                                                <th class="text-left px-4 py-2 text-xs font-semibold text-slate-600 uppercase">Rank</th>
                                                <th class="text-left px-4 py-2 text-xs font-semibold text-slate-600 uppercase">Team</th>
                                                <th class="text-center px-4 py-2 text-xs font-semibold text-slate-600 uppercase">W</th>
                                                <th class="text-center px-4 py-2 text-xs font-semibold text-slate-600 uppercase">L</th>
                                                <th class="text-center px-4 py-2 text-xs font-semibold text-slate-600 uppercase">D</th>
                                                <th class="text-center px-4 py-2 text-xs font-semibold text-slate-600 uppercase">Pts</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200">
                                            @foreach($sportStandings->take(3) as $rank => $standing)
                                                <tr class="hover:bg-slate-50">
                                                    <td class="px-4 py-2">
                                                        @if($rank === 0)
                                                            🥇
                                                        @elseif($rank === 1)
                                                            🥈
                                                        @elseif($rank === 2)
                                                            🥉
                                                        @else
                                                            {{ $rank + 1 }}
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-2 font-medium text-slate-900">{{ $standing->team->name ?? 'N/A' }}</td>
                                                    <td class="text-center px-4 py-2 text-slate-600">{{ $standing->wins ?? 0 }}</td>
                                                    <td class="text-center px-4 py-2 text-slate-600">{{ $standing->losses ?? 0 }}</td>
                                                    <td class="text-center px-4 py-2 text-slate-600">{{ $standing->draws ?? 0 }}</td>
                                                    <td class="text-center px-4 py-2 font-semibold text-slate-900">{{ $standing->points ?? 0 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-slate-500">
                    <p>No standings available yet</p>
                </div>
            @endif
        </div>
    </div>
@endsection
