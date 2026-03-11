@extends('layouts.app')
@section('title', $sport->name . ' Standings')
@section('content')

<div class="space-y-6">
    <!-- Sport Header -->
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $sport->name }} Standings</h1>
            <div class="flex gap-2 mt-3">
                <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded">
                    {{ ucfirst($sport->category) }}
                </span>
                <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-3 py-1 rounded">
                    {{ ucfirst(str_replace('_', ' ', $sport->bracket_type)) }}
                </span>
                @php
                    $statusColors = [
                        'upcoming' => 'bg-blue-100 text-blue-800',
                        'ongoing' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-gray-100 text-gray-800',
                    ];
                    $statusColor = $statusColors[$sport->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-block {{ $statusColor }} text-xs font-semibold px-3 py-1 rounded">
                    {{ ucfirst($sport->status) }}
                </span>
            </div>
        </div>

        <a href="{{ route('tenant.standings.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
            ← Back to Standings
        </a>
    </div>

    <!-- Full Standings Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Team Name</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">W</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">L</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">D</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Pts</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">GP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $standings = $sport->standings()->orderByDesc('points')
                            ->orderByDesc('wins')
                            ->orderByDesc('draws')
                            ->get();
                    @endphp

                    @forelse($standings as $index => $standing)
                        @php
                            $rank = $index + 1;
                            $gamesPlayed = $standing->wins + $standing->losses + $standing->draws;
                            $rankEmoji = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : $rank));

                            $rowBg = $rank === 1 
                                ? 'bg-yellow-50 border-l-4 border-yellow-400' 
                                : ($rank === 2 
                                    ? 'bg-gray-50 border-l-4 border-gray-400' 
                                    : ($rank === 3 
                                        ? 'bg-orange-50 border-l-4 border-orange-400' 
                                        : 'bg-white'));
                        @endphp
                        <tr class="{{ $rowBg }} hover:opacity-75 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $rankEmoji }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('tenant.teams.show', [$university->slug, $standing->team]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $standing->team->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-green-600">
                                {{ $standing->wins }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-red-600">
                                {{ $standing->losses }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-yellow-600">
                                {{ $standing->draws }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-purple-600">
                                {{ $standing->points }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium text-gray-900">
                                {{ $gamesPlayed }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No standings recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Stats Row -->
    @if($standings->count() > 0)
        @php
            $leader = $standings->first();
            $mostGames = $standings->sortByDesc(fn($s) => $s->wins + $s->losses + $s->draws)->first();
            $totalGames = $standings->sum(fn($s) => $s->wins + $s->losses + $s->draws) / 2;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Leader -->
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-2">🏆 Leader</p>
                <p class="text-2xl font-bold text-gray-900">{{ $leader->team->name }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $leader->points }} Points</p>
            </div>

            <!-- Most Games -->
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-2">⚽ Most Games</p>
                <p class="text-2xl font-bold text-gray-900">{{ $mostGames->team->name }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $mostGames->wins + $mostGames->losses + $mostGames->draws }} Games Played</p>
            </div>

            <!-- Total Games -->
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-2">📊 Total Games Played</p>
                <p class="text-2xl font-bold text-gray-900">{{ intval($totalGames) }}</p>
                <p class="text-sm text-gray-500 mt-2">Across all teams</p>
            </div>
        </div>
    @endif
</div>
@endsection
