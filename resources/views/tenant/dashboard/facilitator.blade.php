@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        @if(!$mySport)
            <!-- No Sport Assigned Warning -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-8 text-center">
                <p class="text-amber-900 font-medium mb-2">📋 No Sport Assigned</p>
                <p class="text-amber-700 text-sm">
                    You don't have a sport assigned yet. Contact your administrator to get started.
                </p>
            </div>
        @else
            <!-- Welcome Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">My Sport 🏅</h1>
                    <p class="text-slate-600 mt-2">{{ $mySport->name }} • Sports Facilitator</p>
                </div>
            </div>

            <!-- Sport Header Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl p-8 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $mySport->name }}</h2>
                        <div class="flex gap-2 mt-3">
                            @if($mySport->category)
                                <span class="px-3 py-1 bg-indigo-500 bg-opacity-30 rounded-full text-sm font-medium">
                                    {{ $mySport->category }}
                                </span>
                            @endif
                            <span class="px-3 py-1 bg-indigo-500 bg-opacity-30 rounded-full text-sm font-medium">
                                {{ ucfirst($mySport->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
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
                        <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                            <span class="text-xl">📅</span>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                        {{ $stats['total_schedules'] }}
                    </p>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Scheduled
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                            <span class="text-xl">✅</span>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 leading-none mb-1">
                        {{ $stats['completed_games'] }}
                    </p>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Completed
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-4">Quick Actions</h2>
                <div class="flex flex-wrap gap-3">
                    @can('create', App\Models\Schedule::class)
                        <a href="{{ route('tenant.schedules.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
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

            <!-- Upcoming Games -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-6">Upcoming Games</h2>

                @if($upcomingSchedules->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Match</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Venue</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date & Time</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach($upcomingSchedules as $schedule)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 font-medium text-slate-900">
                                            {{ $schedule->homeTeam->name ?? 'N/A' }} vs {{ $schedule->awayTeam->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">{{ $schedule->venue->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $schedule->scheduled_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                                $schedule->status === 'ongoing' ? 'bg-amber-50 text-amber-700' :
                                                ($schedule->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700')
                                            }}">
                                                {{ ucfirst($schedule->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($schedule->status === 'ongoing')
                                                <a href="{{ route('tenant.results.create', [$university->slug, $schedule]) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                                    Record Result →
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <p>No upcoming games scheduled</p>
                    </div>
                @endif
            </div>

            <!-- Current Standings -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-base font-semibold text-slate-900 mb-6">Current Standings</h2>

                @if($standings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Rank</th>
                                    <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Team</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">W</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">L</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">D</th>
                                    <th class="text-center px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Points</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach($standings as $rank => $standing)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 font-semibold text-slate-900">
                                            @if($rank === 0)
                                                🥇 1st
                                            @elseif($rank === 1)
                                                🥈 2nd
                                            @elseif($rank === 2)
                                                🥉 3rd
                                            @else
                                                {{ $rank + 1 }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium text-slate-900">{{ $standing->team->name ?? 'N/A' }}</td>
                                        <td class="text-center px-4 py-3 text-slate-600">{{ $standing->wins ?? 0 }}</td>
                                        <td class="text-center px-4 py-3 text-slate-600">{{ $standing->losses ?? 0 }}</td>
                                        <td class="text-center px-4 py-3 text-slate-600">{{ $standing->draws ?? 0 }}</td>
                                        <td class="text-center px-4 py-3 font-bold text-indigo-600">{{ $standing->points ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <p>No standings available</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
