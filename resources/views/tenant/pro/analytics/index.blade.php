@extends('layouts.app')
@section('title', 'Analytics & Reports')

@section('content')

{{-- ═══════════════════════════════════ --}}
{{-- PAGE HEADER                         --}}
{{-- ═══════════════════════════════════ --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <h1 class="text-2xl font-bold text-slate-900">
                Analytics & Reports
            </h1>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                ⭐ PRO
            </span>
        </div>
        <p class="text-sm text-slate-500">
            Complete overview of {{ $university->name }}'s intramurals program
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('tenant.analytics.exportPdf', $university->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-600 hover:bg-red-700 text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293 l5.414 5.414a1 1 0 01.293.707 V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </a>
        <a href="{{ route('tenant.analytics.exportExcel', $university->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-emerald-600 hover:bg-emerald-700 text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293 l5.414 5.414a1 1 0 01.293.707 V19a2 2 0 01-2 2z"/>
            </svg>
            Export Excel
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════ --}}
{{-- SECTION 1: KPI CARDS               --}}
{{-- ═══════════════════════════════════ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total Players --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                Active
            </span>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $kpis['total_players'] }}</p>
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-1">Total Players</p>
    </div>

    {{-- Total Teams --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                Registered
            </span>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $kpis['total_teams'] }}</p>
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-1">Total Teams</p>
    </div>

    {{-- Total Sports --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">
                Active
            </span>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $kpis['total_sports'] }}</p>
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-1">Total Sports</p>
    </div>

    {{-- Completion Rate --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <span class="text-xs font-medium {{ $completionRate >= 75 ? 'text-emerald-600 bg-emerald-50' : ($completionRate >= 50 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50') }} px-2 py-0.5 rounded-full">
                {{ $completionRate >= 75 ? 'Great' : ($completionRate >= 50 ? 'Good' : 'Low') }}
            </span>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $kpis['completion_rate'] }}%</p>
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mt-1">Game Completion Rate</p>
        {{-- Mini progress bar --}}
        <div class="mt-3 w-full bg-slate-100 rounded-full h-1.5">
            <div class="h-1.5 rounded-full transition-all duration-700 {{ $completionRate >= 75 ? 'bg-emerald-500' : ($completionRate >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $completionRate }}%"></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════ --}}
{{-- GAME ACTIVITY MINI STATS           --}}
{{-- ═══════════════════════════════════ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    @php
    $activityCards = [
        ['Completed', $gameActivity['completed'], 'emerald', '✅'],
        ['Scheduled', $gameActivity['scheduled'], 'blue', '📅'],
        ['Ongoing',   $gameActivity['ongoing'],   'amber', '🔴'],
        ['Cancelled', $gameActivity['cancelled'], 'red', '❌'],
    ];
    @endphp
    @foreach($activityCards as $card)
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-{{ $card[2] }}-50 flex items-center justify-center flex-shrink-0 text-lg">
            {{ $card[3] }}
        </div>
        <div>
            <p class="text-xl font-bold text-slate-900">{{ $card[1] }}</p>
            <p class="text-xs text-slate-500">{{ $card[0] }} Games</p>
        </div>
    </div>
    @endforeach
</div>

{{-- ═══════════════════════════════════ --}}
{{-- SECTION 2: CHARTS ROW              --}}
{{-- ═══════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- CHART 1: Sports Participation (2/3 width) --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-semibold text-slate-900">Sports Participation</h3>
                <p class="text-xs text-slate-500 mt-0.5">Teams and players per sport</p>
            </div>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-indigo-500 inline-block"></span>
                    Teams
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-sm bg-emerald-500 inline-block"></span>
                    Players
                </span>
            </div>
        </div>
        <div class="p-6" style="min-height: 300px;">
            <div class="w-full" style="height: 280px; position: relative;">
                <canvas id="participationChart" style="display: block; width: 100% !important; height: 100% !important;"></canvas>
            </div>
        </div>
    </div>

    {{-- CHART 2: Game Activity Doughnut (1/3 width) --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold text-slate-900">Game Activity</h3>
            <p class="text-xs text-slate-500 mt-0.5">Status breakdown of all games</p>
        </div>
        <div class="p-6">
            <div class="w-full" style="height: 260px; position: relative;">
                <canvas id="gameActivityChart" style="display: block; width: 100% !important; height: 100% !important;"></canvas>
            </div>
            {{-- Legend --}}
            <div class="mt-4 space-y-2">
                @php
                $activityLegend = [
                    ['Completed', $gameActivity['completed'], '#10B981'],
                    ['Scheduled', $gameActivity['scheduled'], '#3B82F6'],
                    ['Ongoing',   $gameActivity['ongoing'],   '#F59E0B'],
                    ['Cancelled', $gameActivity['cancelled'], '#EF4444'],
                ];
                $totalGamesLocal = array_sum(array_column($activityLegend, 1));
                @endphp
                @foreach($activityLegend as $item)
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: {{ $item[2] }}"></span>
                        <span class="text-slate-600">{{ $item[0] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-slate-900">{{ $item[1] }}</span>
                        <span class="text-slate-400">({{ $totalGamesLocal > 0 ? round(($item[1]/$totalGamesLocal)*100) : 0 }}%)</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════ --}}
{{-- SCHEDULE ACTIVITY PER SPORT        --}}
{{-- ═══════════════════════════════════ --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-slate-900">Schedule Activity by Sport</h3>
            <p class="text-xs text-slate-500 mt-0.5">Completed, scheduled, and cancelled games per sport</p>
        </div>
        <div class="flex items-center gap-3 text-xs">
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-emerald-500 inline-block"></span>
                Completed
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-blue-500 inline-block"></span>
                Scheduled
            </span>
            <span class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-sm bg-red-400 inline-block"></span>
                Cancelled
            </span>
        </div>
    </div>
    <div class="p-6">
        <div class="w-full" style="height: 320px; position: relative;">
            <canvas id="scheduleActivityChart" style="display: block; width: 100% !important; height: 100% !important;"></canvas>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════ --}}
{{-- SECTION 3: LEADERBOARD + VENUES    --}}
{{-- ═══════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- TOP TEAMS LEADERBOARD --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold text-slate-900">🏆 Top Performing Teams</h3>
            <p class="text-xs text-slate-500 mt-0.5">Ranked by points across all sports</p>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($topTeams as $index => $standing)
            @php $rank = $index + 1; @endphp
            <div class="px-6 py-3 flex items-center gap-4 hover:bg-slate-50 transition-colors {{ $rank <= 3 ? 'bg-gradient-to-r' : '' }} {{ $rank === 1 ? 'from-amber-50/50 to-transparent' : '' }} {{ $rank === 2 ? 'from-slate-50/80 to-transparent' : '' }} {{ $rank === 3 ? 'from-orange-50/50 to-transparent' : '' }}">

                {{-- Rank --}}
                <div class="w-8 flex-shrink-0 text-center">
                    @if($rank === 1)
                    <span class="text-xl">🥇</span>
                    @elseif($rank === 2)
                    <span class="text-xl">🥈</span>
                    @elseif($rank === 3)
                    <span class="text-xl">🥉</span>
                    @else
                    <span class="text-sm font-bold text-slate-400">{{ $rank }}</span>
                    @endif
                </div>

                {{-- Team info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $standing->team->name }}</p>
                    <p class="text-xs text-slate-500">{{ $standing->team->sport->name ?? '—' }}</p>
                </div>

                {{-- Stats --}}
                <div class="flex items-center gap-3 text-xs flex-shrink-0">
                    <div class="text-center">
                        <p class="font-bold text-emerald-600">{{ $standing->wins }}</p>
                        <p class="text-slate-400">W</p>
                    </div>
                    <div class="text-center">
                        <p class="font-bold text-red-500">{{ $standing->losses }}</p>
                        <p class="text-slate-400">L</p>
                    </div>
                    <div class="text-center">
                        <p class="font-bold text-amber-500">{{ $standing->draws }}</p>
                        <p class="text-slate-400">D</p>
                    </div>
                    <div class="text-center bg-indigo-50 rounded-lg px-2.5 py-1">
                        <p class="font-bold text-indigo-700 text-sm">{{ $standing->points }}</p>
                        <p class="text-indigo-400 text-xs">pts</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <p class="text-3xl mb-2">🏆</p>
                <p class="text-sm text-slate-500">No standings data yet. Record match results to see team rankings here.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- VENUE UTILIZATION --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-semibold text-slate-900">🏟️ Venue Utilization</h3>
            <p class="text-xs text-slate-500 mt-0.5">Games scheduled per venue</p>
        </div>
        <div class="p-6 space-y-4">
            @forelse($venues as $index => $venue)
            @php
                $pct = $maxVenueCount > 0 ? round(($venue->schedules_count / $maxVenueCount) * 100) : 0;
                $colors = ['indigo', 'blue', 'purple', 'emerald', 'amber'];
                $color = $colors[$index % count($colors)];
            @endphp
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-{{ $color }}-500"></div>
                        <span class="text-sm font-medium text-slate-700">{{ $venue->name }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-slate-900">{{ $venue->schedules_count }}</span>
                        <span class="text-xs text-slate-400">games</span>
                    </div>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="h-2 rounded-full bg-{{ $color }}-500 transition-all duration-700" style="width: {{ $pct }}%"></div>
                </div>
                @if($venue->location)
                <p class="text-xs text-slate-400 mt-0.5">📍 {{ $venue->location }}</p>
                @endif
            </div>
            @empty
            <div class="py-12 text-center">
                <p class="text-3xl mb-2">🏟️</p>
                <p class="text-sm text-slate-500">No venue data yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════ --}}
{{-- SECTION 4: SPORTS HEALTH TABLE     --}}
{{-- ═══════════════════════════════════ --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-slate-900">Sports Health Overview</h3>
            <p class="text-xs text-slate-500 mt-0.5">Detailed breakdown per sport</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Sport</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Teams</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Players</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">Games</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Completion</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Facilitator</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($sportsHealth as $sport)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-900">{{ $sport->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ ucfirst($sport->category) }} · {{ str_replace('_', ' ', ucfirst($sport->bracket_type)) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sport->status === 'ongoing' ? 'bg-emerald-50 text-emerald-700' : ($sport->status === 'upcoming' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-600') }}">
                            {{ ucfirst($sport->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-semibold text-slate-900">{{ $sport->teams_count }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-semibold text-slate-900">{{ $sport->players_count }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-1 text-xs">
                            <span class="text-emerald-600 font-semibold">{{ $sport->completed_count }}</span>
                            <span class="text-slate-300">/</span>
                            <span class="text-slate-600">{{ $sport->schedules_count }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 w-24">
                                <div class="w-full bg-slate-100 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $sport->completion_pct >= 75 ? 'bg-emerald-500' : ($sport->completion_pct >= 50 ? 'bg-amber-500' : 'bg-red-400') }}" style="width: {{ $sport->completion_pct }}%"></div>
                                </div>
                            </div>
                            <span class="text-xs font-medium text-slate-700 w-8">{{ $sport->completion_pct }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($sport->facilitator)
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600 flex-shrink-0">
                                {{ strtoupper(substr($sport->facilitator->name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-slate-700 truncate">{{ $sport->facilitator->name }}</span>
                        </div>
                        @else
                        <span class="text-xs text-slate-400 italic">Unassigned</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <p class="text-3xl mb-2">🏅</p>
                        <p class="text-sm text-slate-500">No sports added yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ═══════════════════════════════════ --}}
{{-- SECTION 5: RECENT RESULTS FEED     --}}
{{-- ═══════════════════════════════════ --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-slate-900">Recent Match Results</h3>
            <p class="text-xs text-slate-500 mt-0.5">Latest 5 recorded match outcomes</p>
        </div>
        <a href="{{ route('tenant.schedules.index', $university->slug) }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
            View all →
        </a>
    </div>
    <div class="divide-y divide-slate-100">
        @forelse($recentResults as $result)
        <div class="px-6 py-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">

            {{-- Sport badge --}}
            <div class="flex-shrink-0">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700">
                    {{ $result->schedule->sport->name ?? '—' }}
                </span>
            </div>

            {{-- Match info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    {{-- Home team --}}
                    <span class="text-sm font-semibold {{ $result->winner_team_id === $result->schedule->home_team_id ? 'text-emerald-700' : 'text-slate-500' }}">
                        {{ $result->schedule->homeTeam->name ?? '—' }}
                    </span>

                    {{-- Score --}}
                    <div class="flex items-center gap-1.5">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg font-bold text-sm {{ $result->home_score > $result->away_score ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $result->home_score }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">vs</span>
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg font-bold text-sm {{ $result->away_score > $result->home_score ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $result->away_score }}
                        </span>
                    </div>

                    {{-- Away team --}}
                    <span class="text-sm font-semibold {{ $result->winner_team_id === $result->schedule->away_team_id ? 'text-emerald-700' : 'text-slate-500' }}">
                        {{ $result->schedule->awayTeam->name ?? '—' }}
                    </span>
                </div>

                <div class="flex items-center gap-2 mt-1">
                    @if($result->winnerTeam)
                    <span class="text-xs text-emerald-600 font-medium">
                        🏆 {{ $result->winnerTeam->name }}
                    </span>
                    @else
                    <span class="text-xs text-amber-600 font-medium">
                        🤝 Draw
                    </span>
                    @endif
                    @if($result->schedule->venue)
                    <span class="text-xs text-slate-400">
                        · 📍 {{ $result->schedule->venue->name }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Date --}}
            <div class="flex-shrink-0 text-right">
                <p class="text-xs font-medium text-slate-700">
                    {{ $result->created_at->format('M d, Y') }}
                </p>
                <p class="text-xs text-slate-400">
                    {{ $result->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center">
            <p class="text-3xl mb-2">📊</p>
            <p class="text-sm text-slate-500">
                No match results recorded yet. Record game results to see them here.
            </p>
        </div>
        @endforelse
    </div>
</div>

@endsection

{{-- ═══════════════════════════════════ --}}
{{-- CHART.JS SCRIPTS                   --}}
{{-- ═══════════════════════════════════ --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Storage for charts
    let charts = {
        participation: null,
        gameActivity: null,
        scheduleActivity: null
    };

    // ─────────────────────────────────────
    // CHART 1: Sports Participation
    // ─────────────────────────────────────
    const participationCtx = document.getElementById('participationChart');
    if (participationCtx && typeof Chart !== 'undefined') {
        try {
            charts.participation = new Chart(participationCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['sport_labels'] ?? []),
                    datasets: [
                        {
                            label: 'Teams',
                            data: @json($chartData['team_counts'] ?? []),
                            backgroundColor: 'rgba(99,102,241,0.85)',
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Players',
                            data: @json($chartData['player_counts'] ?? []),
                            backgroundColor: 'rgba(16,185,129,0.85)',
                            borderRadius: 6,
                            borderSkipped: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleColor: '#94A3B8',
                            bodyColor: '#F1F5F9',
                            padding: 12,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94A3B8', font: { size: 12 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226,232,240,0.6)' },
                            ticks: { stepSize: 1, color: '#94A3B8', font: { size: 11 } }
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error initializing participation chart:', e);
        }
    }

    // ─────────────────────────────────────
    // CHART 2: Game Activity Doughnut
    // ─────────────────────────────────────
    const gameActivityCtx = document.getElementById('gameActivityChart');
    if (gameActivityCtx && typeof Chart !== 'undefined') {
        try {
            charts.gameActivity = new Chart(gameActivityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Scheduled', 'Ongoing', 'Cancelled'],
                    datasets: [{
                        data: [
                            {{ $gameActivity['completed'] }},
                            {{ $gameActivity['scheduled'] }},
                            {{ $gameActivity['ongoing'] }},
                            {{ $gameActivity['cancelled'] }},
                        ],
                        backgroundColor: [
                            'rgba(16,185,129,0.9)',
                            'rgba(59,130,246,0.9)',
                            'rgba(245,158,11,0.9)',
                            'rgba(239,68,68,0.9)',
                        ],
                        borderWidth: 0,
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleColor: '#94A3B8',
                            bodyColor: '#F1F5F9',
                            padding: 12,
                            cornerRadius: 8,
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error initializing game activity chart:', e);
        }
    }

    // ─────────────────────────────────────
    // CHART 3: Schedule Activity per Sport
    // ─────────────────────────────────────
    const scheduleActivityCtx = document.getElementById('scheduleActivityChart');
    if (scheduleActivityCtx && typeof Chart !== 'undefined') {
        try {
            const scheduleData = @json($chartData['schedule_activity'] ?? []);

            charts.scheduleActivity = new Chart(scheduleActivityCtx, {
                type: 'bar',
                data: {
                    labels: scheduleData.map(d => d.sport),
                    datasets: [
                        {
                            label: 'Completed',
                            data: scheduleData.map(d => d.completed),
                            backgroundColor: 'rgba(16,185,129,0.85)',
                            borderRadius: 4,
                            borderSkipped: false,
                        },
                        {
                            label: 'Scheduled',
                            data: scheduleData.map(d => d.scheduled),
                            backgroundColor: 'rgba(59,130,246,0.85)',
                            borderRadius: 4,
                            borderSkipped: false,
                        },
                        {
                            label: 'Cancelled',
                            data: scheduleData.map(d => d.cancelled),
                            backgroundColor: 'rgba(239,68,68,0.75)',
                            borderRadius: 4,
                            borderSkipped: false,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F172A',
                            titleColor: '#94A3B8',
                            bodyColor: '#F1F5F9',
                            padding: 12,
                            cornerRadius: 8,
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: { display: false },
                            ticks: { color: '#94A3B8', font: { size: 12 } }
                        },
                        y: {
                            stacked: false,
                            beginAtZero: true,
                            grid: { color: 'rgba(226,232,240,0.6)' },
                            ticks: { stepSize: 1, color: '#94A3B8', font: { size: 11 } }
                        }
                    }
                }
            });
        } catch (e) {
            console.error('Error initializing schedule activity chart:', e);
        }
    }
});
</script>
@endpush
