@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        @if(!$myPlayer)
            <!-- No Player Profile Warning -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-8 text-center">
                <p class="text-blue-900 font-medium mb-2">👤 No Player Profile</p>
                <p class="text-blue-700 text-sm">
                    You don't have a player profile yet. Contact your administrator to get started.
                </p>
            </div>
        @else
            <!-- Player Hero Card -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl p-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-full bg-emerald-500 bg-opacity-30 flex items-center justify-center text-4xl font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">{{ auth()->user()->name }}</h1>
                            <p class="text-emerald-100 mt-1">{{ $myPlayer->university->name ?? 'University' }}</p>
                            @if($myPlayer->jersey_number)
                                <div class="flex gap-2 mt-3">
                                    <span class="px-3 py-1 bg-emerald-500 bg-opacity-30 rounded-full text-sm font-semibold">
                                        Jersey #{{ $myPlayer->jersey_number }}
                                    </span>
                                    @if($myPlayer->position)
                                        <span class="px-3 py-1 bg-emerald-500 bg-opacity-30 rounded-full text-sm font-medium">
                                            {{ $myPlayer->position }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- My Team Card -->
                    @if($myPlayer->team)
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                            <h2 class="text-base font-semibold text-slate-900 mb-4">My Team</h2>
                            <div class="border border-slate-200 rounded-lg p-4 bg-slate-50">
                                <p class="text-sm text-slate-600 font-medium mb-1">Team Name</p>
                                <p class="text-xl font-bold text-slate-900 mb-4">{{ $myPlayer->team->name }}</p>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-slate-600 font-medium">Sport</p>
                                        <p class="text-slate-900">{{ $myPlayer->team->sport->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-600 font-medium">Coach</p>
                                        <p class="text-slate-900">{{ $myPlayer->team->coach->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Next Game Card -->
                        @php
                            $nextGame = $upcomingSchedules->first();
                        @endphp
                        @if($nextGame)
                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                                <h2 class="text-base font-semibold text-slate-900 mb-4">Next Game</h2>
                                <div class="border border-amber-200 rounded-lg p-4 bg-amber-50">
                                    @php
                                        $isHome = $nextGame->home_team_id === $myPlayer->team_id;
                                        $opponent = $isHome ? $nextGame->awayTeam : $nextGame->homeTeam;
                                    @endphp
                                    <p class="text-sm text-amber-600 font-semibold mb-3">
                                        {{ $isHome ? '🏠 HOME' : '🚗 AWAY' }}
                                    </p>
                                    <div class="text-center mb-4">
                                        <p class="text-2xl font-bold text-slate-900">
                                            {{ $myPlayer->team->name }} vs {{ $opponent->name ?? 'TBD' }}
                                        </p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                        <div>
                                            <p class="text-slate-600 font-medium">Date & Time</p>
                                            <p class="text-slate-900 font-semibold">{{ $nextGame->scheduled_at?->format('M d, Y') }} @ {{ $nextGame->scheduled_at?->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-slate-600 font-medium">Venue</p>
                                            <p class="text-slate-900 font-semibold">{{ $nextGame->venue->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- My Schedule -->
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                            <h2 class="text-base font-semibold text-slate-900 mb-6">My Schedule</h2>

                            @if($upcomingSchedules->count() > 0)
                                <div class="space-y-3">
                                    @foreach($upcomingSchedules as $schedule)
                                        @php
                                            $isHome = $schedule->home_team_id === $myPlayer->team_id;
                                            $opponent = $isHome ? $schedule->awayTeam : $schedule->homeTeam;
                                        @endphp
                                        <div class="border border-slate-200 rounded-lg p-4 hover:bg-slate-50 transition">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-slate-600 mb-1">
                                                        {{ $isHome ? '🏠 Home vs' : '🚗 Away at' }} {{ $opponent->name ?? 'TBD' }}
                                                    </p>
                                                    <p class="text-sm text-slate-900 font-medium">
                                                        {{ $schedule->scheduled_at?->format('M d, Y H:i') ?? 'TBD' }}
                                                    </p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                                    $schedule->status === 'ongoing' ? 'bg-amber-50 text-amber-700' :
                                                    ($schedule->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700')
                                                }}">
                                                    {{ ucfirst($schedule->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-slate-500">
                                    <p>No upcoming games</p>
                                </div>
                            @endif
                        </div>
                    @endif
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

                    <!-- Sport Standings (Read-Only) -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h3 class="text-base font-semibold text-slate-900 mb-4">Sport Standings</h3>

                        @if($allStandings->count() > 0)
                            <div class="space-y-2">
                                @foreach($allStandings->take(5) as $rank => $standingRow)
                                    <div class="flex items-center justify-between p-3 border border-slate-200 rounded-lg {{ $standingRow->team_id === $myPlayer->team_id ? 'bg-emerald-50 border-emerald-200' : 'hover:bg-slate-50' }}">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-slate-900">
                                                {{ $rank + 1 }}. {{ $standingRow->team->name ?? 'N/A' }}
                                                @if($standingRow->team_id === $myPlayer->team_id)
                                                    <span class="text-emerald-600 font-bold ml-2">← You</span>
                                                @endif
                                            </p>
                                        </div>
                                        <p class="text-sm font-bold text-slate-900">{{ $standingRow->points ?? 0 }}pts</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500 text-sm">
                                <p>No standings available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
