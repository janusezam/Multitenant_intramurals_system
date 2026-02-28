@extends('layouts.app')
@section('title', 'Standings')

<div class="space-y-6">
    <!-- Heading -->
    <h1 class="text-2xl font-bold text-gray-900">Standings 🏆</h1>

    <!-- Sports Standings -->
    @forelse($sports as $sport)
        @php
            $standings = $sport->standings()->orderByDesc('points')
                ->orderByDesc('wins')
                ->orderByDesc('draws')
                ->get();
        @endphp

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">{{ $sport->name }}</h2>
                    <div class="flex gap-2 mt-2">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">
                            {{ ucfirst($sport->category) }}
                        </span>
                        <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-2 py-1 rounded">
                            {{ ucfirst(str_replace('_', ' ', $sport->bracket_type)) }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('tenant.standings.show', [$university->slug, $sport]) }}" class="px-4 py-2 text-indigo-600 hover:text-indigo-800 font-medium">
                    View Full Standings →
                </a>
            </div>

            <!-- Table -->
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Form</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($standings as $index => $standing)
                                @php
                                    $rank = $index + 1;
                                    $rankEmoji = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : $rank));
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $rankEmoji }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tenant.teams.show', [$university->slug, $standing->team]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            {{ $standing->team->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium text-green-600">
                                        {{ $standing->wins }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium text-red-600">
                                        {{ $standing->losses }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium text-yellow-600">
                                        {{ $standing->draws }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-purple-600">
                                        {{ $standing->points }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-1">
                                            @for($i = 0; $i < min($standing->wins, 5); $i++)
                                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                            @endfor
                                            @for($i = 0; $i < min($standing->losses, 5); $i++)
                                                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                            @endfor
                                            @for($i = 0; $i < min($standing->draws, 5); $i++)
                                                <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-8 text-center text-gray-500">
                    No games played yet for this sport.
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 mb-2">No sports with standings found.</p>
            <p class="text-gray-400 text-sm">Games must be played to generate standings.</p>
        </div>
    @endforelse
</div>
