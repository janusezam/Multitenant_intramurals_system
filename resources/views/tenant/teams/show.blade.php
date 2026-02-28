@extends('layouts.app')
@section('title', $team->name)

<div class="space-y-6">
    <!-- Team Header -->
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $team->name }}</h1>

                <div class="flex gap-3 mt-4">
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded">
                        {{ $team->sport->name }}
                    </span>
                </div>

                <div class="mt-4">
                    @if($team->coach)
                        <p class="text-gray-700">👤 Coach: {{ $team->coach->name }}</p>
                    @else
                        <p class="text-gray-500">👤 No coach assigned</p>
                    @endif
                </div>
            </div>

            <div class="flex gap-2">
                @can('manage teams')
                    <a href="{{ route('tenant.teams.edit', [$university->slug, $team]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('tenant.teams.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Standing Card -->
    @if($standing)
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg shadow border border-indigo-200 p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Current Standing 🏆</h2>
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $standing->wins }}</p>
                    <p class="text-xs text-gray-600 uppercase mt-1">Wins</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-red-600">{{ $standing->losses }}</p>
                    <p class="text-xs text-gray-600 uppercase mt-1">Losses</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $standing->draws }}</p>
                    <p class="text-xs text-gray-600 uppercase mt-1">Draws</p>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-3xl font-bold text-purple-600">{{ $standing->points }}</p>
                    <p class="text-xs text-gray-600 uppercase mt-1">Points</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Players Roster Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Players Roster 🎽</h2>
            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded">
                {{ $players->count() }} players
            </span>
        </div>

        @if($players->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Jersey #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Player Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($players as $player)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    @if($player->jersey_number)
                                        <span class="inline-block bg-indigo-600 text-white font-bold w-10 h-10 rounded-full flex items-center justify-center text-sm">
                                            {{ $player->jersey_number }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $player->user->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $player->position ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <a href="{{ route('tenant.players.show', [$university->slug, $player]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        View
                                    </a>
                                    @can('manage players')
                                        <form action="{{ route('tenant.players.destroy', [$university->slug, $player]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Remove this player from the team?')) $event.preventDefault()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                                Remove
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center">
                <p class="text-gray-500 mb-4">No players registered in this team yet.</p>
                @can('manage players')
                    <a href="{{ route('tenant.players.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        + Add Player
                    </a>
                @endcan
            </div>
        @endif
    </div>

    <!-- Schedule Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Team Schedules 📅</h2>
        </div>

        @if($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Opponent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Venue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schedules as $schedule)
                            @php
                                $isHome = $schedule->home_team_id === $team->id;
                                $opponent = $isHome ? $schedule->awayTeam->name : $schedule->homeTeam->name;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $opponent }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $schedule->venue->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $schedule->scheduled_at->format('M d, Y · h:i A') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($isHome)
                                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Home</span>
                                    @else
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Away</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('tenant.schedules.show', [$university->slug, $schedule]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                        View Game
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                No scheduled games for this team.
            </div>
        @endif
    </div>
</div>
