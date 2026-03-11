@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        @if(!$myTeam)
            <!-- No Team Assigned Warning -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-8 text-center">
                <p class="text-amber-900 font-medium mb-2">⚽ No Team Assigned</p>
                <p class="text-amber-700 text-sm">
                    You don't have a team assigned yet. Contact your administrator to get started.
                </p>
            </div>
        @else
            <!-- Welcome Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">My Team 👥</h1>
                    <p class="text-slate-600 mt-2">Coach: {{ auth()->user()->name }}</p>
                </div>
            </div>

            <!-- Team Header Card -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $myTeam->name }}</h2>
                        <div class="flex gap-2 mt-3">
                            <span class="px-3 py-1 bg-blue-500 bg-opacity-30 rounded-full text-sm font-medium">
                                {{ $myTeam->sport->name ?? 'Unknown Sport' }}
                            </span>
                            <span class="px-3 py-1 bg-blue-500 bg-opacity-30 rounded-full text-sm font-medium">
                                {{ $myTeam->players_count }} Players
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Upcoming Schedule -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h2 class="text-base font-semibold text-slate-900 mb-6">Upcoming Schedule</h2>

                        @if($upcomingSchedules->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-slate-200 bg-slate-50">
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Opponent</th>
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">H/A</th>
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Venue</th>
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Date & Time</th>
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @foreach($upcomingSchedules as $schedule)
                                            @php
                                                $isHome = $schedule->home_team_id === $myTeam->id;
                                                $opponent = $isHome ? $schedule->awayTeam : $schedule->homeTeam;
                                            @endphp
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-4 py-3 font-medium text-slate-900">{{ $opponent->name ?? 'N/A' }}</td>
                                                <td class="px-4 py-3 text-slate-600 font-semibold">
                                                    {{ $isHome ? '🏠 Home' : '🚗 Away' }}
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

                    <!-- Players Roster -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h2 class="text-base font-semibold text-slate-900 mb-6">Players Roster</h2>

                        @if($myTeam->players->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-slate-200 bg-slate-50">
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Jersey</th>
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Name</th>
                                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-600 uppercase tracking-wider">Position</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @foreach($myTeam->players as $player)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-4 py-3 font-bold text-lg text-indigo-600">
                                                    #{{ $player->jersey_number ?? '—' }}
                                                </td>
                                                <td class="px-4 py-3 font-medium text-slate-900">
                                                    {{ $player->user->name ?? 'N/A' }}
                                                </td>
                                                <td class="px-4 py-3 text-slate-600">{{ $player->position ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <p>No players in your team yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column (1/3) -->
                <div class="space-y-6">
                    <!-- Team Standing Card -->
                    @if($standing)
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                            <h3 class="text-base font-semibold text-slate-900 mb-6">Team Standing</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <p class="text-3xl font-bold text-indigo-600 mb-1">
                                        @if($standing && isset($standing->rank))
                                            @if($standing->rank === 1)
                                                🥇
                                            @elseif($standing->rank === 2)
                                                🥈
                                            @elseif($standing->rank === 3)
                                                🥉
                                            @else
                                                {{ $standing->rank }}
                                            @endif
                                        @endif
                                    </p>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Rank</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-3xl font-bold text-slate-900 mb-1">{{ $standing->points ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Points</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-emerald-600 mb-1">{{ $standing->wins ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Wins</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-red-600 mb-1">{{ $standing->losses ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Losses</p>
                                </div>
                                <div class="col-span-2 text-center">
                                    <p class="text-2xl font-bold text-slate-600 mb-1">{{ $standing->draws ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 uppercase">Draws</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Sport Info Card -->
                    @if($myTeam->sport)
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                            <h3 class="text-base font-semibold text-slate-900 mb-4">Sport Info</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <p class="text-slate-500 text-xs font-medium uppercase tracking-wider mb-1">Name</p>
                                    <p class="text-slate-900 font-medium">{{ $myTeam->sport->name }}</p>
                                </div>
                                @if($myTeam->sport->category)
                                    <div>
                                        <p class="text-slate-500 text-xs font-medium uppercase tracking-wider mb-1">Category</p>
                                        <p class="text-slate-900 font-medium">{{ $myTeam->sport->category }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-slate-500 text-xs font-medium uppercase tracking-wider mb-1">Status</p>
                                    <p class="text-slate-900 font-medium capitalize">{{ $myTeam->sport->status }}</p>
                                </div>
                                @if($myTeam->sport->facilitator)
                                    <div>
                                        <p class="text-slate-500 text-xs font-medium uppercase tracking-wider mb-1">Facilitator</p>
                                        <p class="text-slate-900 font-medium">{{ $myTeam->sport->facilitator->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
