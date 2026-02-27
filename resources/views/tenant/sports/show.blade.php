@extends('layouts.app')
@section('title', $sport->name)

<div class="space-y-6">
    <!-- Sport Header -->
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $sport->name }}</h1>
                <div class="flex gap-2 mt-3">
                    @php
                        $categoryLabel = $sport->category === 'team' ? 'Team Sport' : 'Individual Sport';
                        $categoryColor = $sport->category === 'team' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800';

                        $bracketLabel = str_replace('_', ' ', ucfirst($sport->bracket_type));
                        $bracketColors = [
                            'single_elimination' => 'bg-orange-100 text-orange-800',
                            'double_elimination' => 'bg-red-100 text-red-800',
                            'round_robin' => 'bg-teal-100 text-teal-800',
                        ];
                        $bracketColor = $bracketColors[$sport->bracket_type] ?? 'bg-gray-100 text-gray-800';

                        $statusBadgeColor = [
                            'upcoming' => 'bg-blue-100 text-blue-800',
                            'ongoing' => 'bg-green-100 text-green-800',
                            'completed' => 'bg-gray-100 text-gray-800',
                        ][$sport->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp

                    <span class="inline-block {{ $categoryColor }} text-xs font-semibold px-3 py-1 rounded">
                        {{ $categoryLabel }}
                    </span>
                    <span class="inline-block {{ $bracketColor }} text-xs font-semibold px-3 py-1 rounded">
                        {{ $bracketLabel }}
                    </span>
                    <span class="inline-block {{ $statusBadgeColor }} text-xs font-semibold px-3 py-1 rounded capitalize">
                        {{ $sport->status }}
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                @can('manage sports')
                    <a href="{{ route('tenant.sports.edit', [$university->slug, $sport]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('tenant.sports.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Back
                </a>
            </div>
        </div>

        <!-- Facilitator Info -->
        @if($sport->facilitator)
            <p class="text-gray-700">
                <span class="font-medium">Facilitator:</span> {{ $sport->facilitator->name }}
            </p>
        @else
            <p class="text-gray-500">
                <span class="font-medium">Facilitator:</span> Not assigned
            </p>
        @endif
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Teams</p>
            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $teams->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Total Players</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $players->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Scheduled Games</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $schedules->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Completed Games</p>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $completedGames->count() }}</p>
        </div>
    </div>

    <!-- Teams Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Teams 👥 ({{ $teams->count() }})</h2>
        </div>

        @if($teams->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                @foreach($teams as $team)
                    <a href="{{ route('tenant.teams.show', [$university->slug, $team]) }}" class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <h3 class="font-bold text-gray-900">{{ $team->name }}</h3>
                        @if($team->coach)
                            <p class="text-sm text-gray-600 mt-1">Coach: {{ $team->coach->name }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-2">👥 {{ $team->players_count ?? 0 }} players</p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                No teams registered for this sport.
            </div>
        @endif
    </div>

    <!-- Schedules Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Upcoming Schedules 📅</h2>
        </div>

        @if($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Match</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Venue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('tenant.schedules.show', [$university->slug, $schedule]) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                        {{ $schedule->homeTeam->name }} vs {{ $schedule->awayTeam->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->venue->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->scheduled_at->format('M d, Y · h:i A') }}</td>
                                <td class="px-6 py-4">
                                    @if($schedule->status === 'scheduled')
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Scheduled</span>
                                    @elseif($schedule->status === 'ongoing')
                                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Ongoing</span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                No upcoming schedules for this sport.
            </div>
        @endif
    </div>

    <!-- Standings Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Current Standings 🏆</h2>
        </div>

        @if($standings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Team</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">W</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">L</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">D</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Pts</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($standings as $idx => $standing)
                            <tr class="hover:bg-gray-50 @if($idx === 0) bg-yellow-50 border-l-4 border-l-yellow-400 @elseif($idx === 1) bg-gray-50 border-l-4 border-l-gray-400 @elseif($idx === 2) bg-orange-50 border-l-4 border-l-orange-400 @endif">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    @if($idx === 0) 🥇 @elseif($idx === 1) 🥈 @elseif($idx === 2) 🥉 @endif
                                    #{{ $idx + 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $standing->team->name }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $standing->wins }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $standing->losses }}</td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $standing->draws }}</td>
                                <td class="px-6 py-4 text-center font-bold text-gray-900">{{ $standing->points }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-200 text-right">
                <a href="{{ route('tenant.standings.show', [$university->slug, $sport->slug]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    View Full Standings →
                </a>
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                No standings available yet.
            </div>
        @endif
    </div>
</div>
