@extends('layouts.app')
@section('title', 'Game Details')

<div class="space-y-6">
    <!-- Match Header Card -->
    <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg shadow border border-indigo-200 p-8">
        <div class="text-center">
            <div class="flex gap-3 justify-center mb-6">
                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded">
                    {{ $schedule->sport->name }}
                </span>

                @php
                    $statusColors = [
                        'scheduled' => 'bg-blue-100 text-blue-800',
                        'ongoing' => 'bg-amber-100 text-amber-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-gray-100 text-gray-500',
                    ];
                    $statusColor = $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-block {{ $statusColor }} text-xs font-semibold px-3 py-1 rounded">
                    {{ ucfirst($schedule->status) }}
                </span>
            </div>

            <div class="mb-6">
                <div class="flex items-center justify-center gap-4">
                    <div class="flex-1">
                        <p class="text-3xl font-bold text-gray-900">{{ $schedule->homeTeam->name }}</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-500">vs</p>
                    <div class="flex-1">
                        <p class="text-3xl font-bold text-gray-900">{{ $schedule->awayTeam->name }}</p>
                    </div>
                </div>
            </div>

            <div class="text-gray-700">
                <p class="mb-1">📍 {{ $schedule->venue->name }}</p>
                <p>📅 {{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('D, M d Y · h:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-2 justify-center flex-wrap">
        <a href="{{ route('tenant.schedules.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
            ← Back to Schedules
        </a>

        @can('manage schedules')
            @if(!in_array($schedule->status, ['completed', 'cancelled']))
                <a href="{{ route('tenant.schedules.edit', [$university->slug, $schedule]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Edit Schedule
                </a>
            @endif
        @endcan

        @can('manage results')
            @if(!$schedule->matchResult && $schedule->status !== 'cancelled')
                <a href="{{ route('tenant.results.create', [$university->slug, $schedule]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                    Record Result
                </a>
            @elseif($schedule->matchResult)
                <a href="{{ route('tenant.results.edit', [$university->slug, $schedule]) }}" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium">
                    Edit Result
                </a>
            @endif
        @endcan
    </div>

    <!-- Result Card -->
    @if($schedule->matchResult)
        <div class="bg-white rounded-lg shadow">
            <div class="bg-green-600 text-white px-6 py-4 rounded-t-lg">
                <h2 class="text-lg font-bold">Match Result 🏆</h2>
            </div>

            <div class="p-8">
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center gap-6">
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 mb-2">{{ $schedule->homeTeam->name }}</p>
                            <p class="text-4xl font-bold text-indigo-600">{{ $schedule->matchResult->home_score }}</p>
                        </div>
                        <p class="text-2xl font-bold text-gray-500">:</p>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 mb-2">{{ $schedule->awayTeam->name }}</p>
                            <p class="text-4xl font-bold text-indigo-600">{{ $schedule->matchResult->away_score }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 space-y-3">
                    <div class="text-center">
                        <p class="text-gray-600">🏆 Winner:</p>
                        @if($schedule->matchResult->winner_team_id)
                            <p class="text-lg font-bold text-gray-900">
                                @if($schedule->matchResult->winner_team_id === $schedule->home_team_id)
                                    {{ $schedule->homeTeam->name }}
                                @else
                                    {{ $schedule->awayTeam->name }}
                                @endif
                            </p>
                        @else
                            <p class="text-lg font-bold text-gray-900">Draw 🤝</p>
                        @endif
                    </div>

                    @if($schedule->matchResult->remarks)
                        <div>
                            <p class="text-gray-600 text-sm">Remarks:</p>
                            <p class="text-gray-900">{{ $schedule->matchResult->remarks }}</p>
                        </div>
                    @endif

                    @if($schedule->matchResult->user)
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Recorded by: {{ $schedule->matchResult->user->name }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        @if($schedule->status !== 'cancelled')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
                <p class="text-gray-700 mb-4">No result recorded yet for this game.</p>
                @can('manage results')
                    <a href="{{ route('tenant.results.create', [$university->slug, $schedule]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                        Record Result Now
                    </a>
                @endcan
            </div>
        @endif
    @endif
</div>
