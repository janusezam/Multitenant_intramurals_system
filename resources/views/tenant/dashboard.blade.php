@extends('layouts.app')
@section('title', 'Dashboard')

<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-lg shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-indigo-100 mt-2">
                    {{ $university->name }} · {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                </p>
            </div>
            <div>
                @if($university->plan === 'pro')
                    <span class="inline-block bg-yellow-400 text-yellow-900 font-bold px-4 py-2 rounded-lg text-lg">
                        PRO PLAN ⭐
                    </span>
                @else
                    <span class="inline-block bg-gray-300 text-gray-800 font-bold px-4 py-2 rounded-lg text-lg">
                        BASIC PLAN
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Sports -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Sports</p>
                    <p class="text-3xl font-bold text-indigo-700 mt-2">{{ $stats['total_sports'] }}</p>
                </div>
                <span class="text-3xl">🏅</span>
            </div>
        </div>

        <!-- Total Teams -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Teams</p>
                    <p class="text-3xl font-bold text-blue-700 mt-2">{{ $stats['total_teams'] }}</p>
                </div>
                <span class="text-3xl">👥</span>
            </div>
        </div>

        <!-- Total Players -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Players</p>
                    <p class="text-3xl font-bold text-green-700 mt-2">{{ $stats['total_players'] }}</p>
                </div>
                <span class="text-3xl">🎽</span>
            </div>
        </div>

        <!-- Total Venues -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Venues</p>
                    <p class="text-3xl font-bold text-purple-700 mt-2">{{ $stats['total_venues'] }}</p>
                </div>
                <span class="text-3xl">🏟️</span>
            </div>
        </div>

        <!-- Upcoming Games -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Upcoming Games</p>
                    <p class="text-3xl font-bold text-yellow-700 mt-2">{{ $stats['upcoming_schedules'] }}</p>
                </div>
                <span class="text-3xl">📅</span>
            </div>
        </div>

        <!-- Ongoing Sports -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-600">Ongoing Sports</p>
                    <p class="text-3xl font-bold text-red-700 mt-2">{{ $stats['ongoing_sports'] }}</p>
                </div>
                <span class="text-3xl">🔴</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('tenant.sports.create', $university->slug) }}" class="px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-center transition">
            + Add Sport
        </a>
        <a href="{{ route('tenant.teams.create', $university->slug) }}" class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-center transition">
            + Add Team
        </a>
        <a href="{{ route('tenant.schedules.create', $university->slug) }}" class="px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-center transition">
            + Schedule Game
        </a>
        <a href="{{ route('tenant.standings.index', $university->slug) }}" class="px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium text-center transition">
            View Standings
        </a>
    </div>

    <!-- Upcoming Schedules Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Upcoming Games 📅</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Match</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Venue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentSchedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $schedule->sport->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">
                                    {{ $schedule->homeTeam->name }} vs {{ $schedule->awayTeam->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $schedule->venue->name }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $schedule->scheduled_at->format('M d, Y · h:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($schedule->status === 'scheduled')
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Scheduled</span>
                                @elseif($schedule->status === 'ongoing')
                                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Ongoing</span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($schedule->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('tenant.schedules.show', [$university->slug, $schedule]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No upcoming games scheduled.
                                <a href="{{ route('tenant.schedules.create', $university->slug) }}" class="block mt-2 text-indigo-600 hover:text-indigo-800 font-medium">
                                    + Schedule a Game
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Standings Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Current Standings 🏆</h2>
        </div>

        @forelse($sportsWithStandings as $sport)
            <div class="p-6 border-b border-gray-200 last:border-b-0">
                <h3 class="text-md font-bold text-gray-900 mb-4">{{ $sport->name }}</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left font-medium text-gray-700">Rank</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-700">Team</th>
                                <th class="px-4 py-2 text-center font-medium text-gray-700">W</th>
                                <th class="px-4 py-2 text-center font-medium text-gray-700">L</th>
                                <th class="px-4 py-2 text-center font-medium text-gray-700">D</th>
                                <th class="px-4 py-2 text-center font-medium text-gray-700">Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($sport->standings ?? [], 0, 3) as $idx => $standing)
                                <tr class="border-b border-gray-200 @if($idx === 0) border-l-4 border-l-yellow-400 bg-yellow-50 @elseif($idx === 1) border-l-4 border-l-gray-400 bg-gray-50 @elseif($idx === 2) border-l-4 border-l-orange-400 bg-orange-50 @endif">
                                    <td class="px-4 py-3 font-bold text-gray-900">
                                        @if($idx === 0) 🥇 @elseif($idx === 1) 🥈 @elseif($idx === 2) 🥉 @endif
                                        #{{ $idx + 1 }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $standing->team->name }}</td>
                                    <td class="px-4 py-3 text-center text-gray-700">{{ $standing->wins }}</td>
                                    <td class="px-4 py-3 text-center text-gray-700">{{ $standing->losses }}</td>
                                    <td class="px-4 py-3 text-center text-gray-700">{{ $standing->draws }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-gray-900">{{ $standing->points }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('tenant.standings.show', [$university->slug, $sport]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm mt-3 inline-block">
                    View Full Standings →
                </a>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                No ongoing sports with standings yet.
            </div>
        @endforelse
    </div>
</div>
