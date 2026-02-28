@extends('layouts.app')
@section('title', $sport->name . ' Bracket')

<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $sport->name }} Tournament Bracket 🎯</h1>

                @php
                    $bracketTypeColors = [
                        'single_elimination' => 'bg-orange-100 text-orange-800',
                        'double_elimination' => 'bg-red-100 text-red-800',
                        'round_robin' => 'bg-teal-100 text-teal-800',
                    ];
                    $bracketTypeColor = $bracketTypeColors[$sport->bracket->type] ?? 'bg-gray-100 text-gray-800';

                    $statusColors = [
                        'active' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-gray-100 text-gray-800',
                        'draft' => 'bg-yellow-100 text-yellow-800',
                    ];
                    $statusColor = $statusColors[$sport->bracket->status] ?? 'bg-gray-100 text-gray-800';
                @endphp

                <div class="flex gap-2 mt-3">
                    <span class="inline-block {{ $bracketTypeColor }} text-xs font-semibold px-3 py-1 rounded">
                        {{ ucfirst(str_replace('_', ' ', $sport->bracket->type)) }}
                    </span>
                    <span class="inline-block {{ $statusColor }} text-xs font-semibold px-3 py-1 rounded">
                        {{ ucfirst($sport->bracket->status) }}
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('tenant.brackets.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    ← Back
                </a>

                @can('manage brackets')
                    <form action="{{ route('tenant.brackets.reset', [$university->slug, $sport->id]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Are you sure? This will DELETE all bracket matches and cannot be undone.')) $event.preventDefault()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 border border-red-600 text-red-600 hover:bg-red-50 rounded-lg font-medium">
                            Reset Bracket
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

    <!-- Bracket Display -->
    @if($sport->bracket->type === 'round_robin')
        <!-- Round Robin Display -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Round Robin Matches</h2>

            @php
                $matches = $sport->bracket->matches()->get();
            @endphp

            @if($matches->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Match #</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Team A</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">VS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Team B</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Winner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($matches as $index => $match)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-right text-gray-900">
                                        {{ $match->teamA?->name ?? 'BYE' }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-500 text-sm">vs</td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $match->teamB?->name ?? 'BYE' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($match->winner_id)
                                            <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                                ✅ {{ $match->winner->name }}
                                            </span>
                                        @else
                                            <span class="inline-block bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(!$match->winner_id && $match->teamA && $match->teamB)
                                            <form method="POST" action="{{ route('tenant.brackets.updateMatch', [$university->slug, $match->id]) }}" class="flex gap-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="winner_id" required class="text-xs border border-gray-300 rounded px-2 py-1">
                                                    <option value="">-- Select --</option>
                                                    <option value="{{ $match->team_a_id }}">{{ $match->teamA->name }}</option>
                                                    <option value="{{ $match->team_b_id }}">{{ $match->teamB->name }}</option>
                                                </select>
                                                <button type="submit" class="text-xs bg-indigo-600 text-white rounded px-2 py-1 hover:bg-indigo-700">
                                                    ✓
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No matches in this bracket yet.</p>
            @endif
        </div>
    @else
        <!-- Single/Double Elimination Display (Column Layout) -->
        <div class="bg-white rounded-lg shadow p-6 overflow-x-auto">
            @php
                $matchesByRound = $sport->bracket->matches()
                    ->get()
                    ->groupBy('round')
                    ->sortKeys();
            @endphp

            @if($matchesByRound->count() > 0)
                <div class="flex gap-6 pb-4" style="min-width: min-content;">
                    @foreach($matchesByRound as $round => $matches)
                        <div class="flex flex-col gap-4 min-w-48">
                            <!-- Round Header -->
                            <div class="text-center">
                                @if($round === 'final')
                                    <h3 class="text-sm font-bold text-gray-900">🏆 Final</h3>
                                @else
                                    <h3 class="text-sm font-bold text-gray-900">Round {{ $round }}</h3>
                                @endif
                            </div>

                            <!-- Match Cards -->
                            @foreach($matches as $match)
                                @include('tenant.pro.brackets._partials.match_card', [
                                    'match' => $match,
                                    'university' => $university
                                ])
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No matches in this bracket yet.</p>
            @endif
        </div>
    @endif

    <!-- Champion Section -->
    @if($sport->bracket->status === 'completed' && $champion)
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg shadow p-8 text-center border-2 border-yellow-300">
            <h2 class="text-2xl font-bold text-yellow-900 mb-4">🏆 Tournament Champion! 🏆</h2>
            <p class="text-4xl font-bold text-yellow-700 mb-2">{{ $champion->name }}</p>
            <p class="text-yellow-800">{{ $sport->name }} Champion</p>

            <!-- Confetti effect using CSS -->
            <style>
                @keyframes confetti-fall {
                    to { transform: translateY(100vh) rotate(360deg); opacity: 0; }
                }
                .confetti {
                    position: fixed;
                    pointer-events: none;
                    animation: confetti-fall 3s ease-in forwards;
                }
            </style>
        </div>
    @endif
</div>
