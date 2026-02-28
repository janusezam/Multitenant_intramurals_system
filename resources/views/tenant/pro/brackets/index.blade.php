@extends('layouts.app')
@section('title', 'Bracket Generator')

<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-gray-900">Bracket Generator 🎯</h1>
            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded">
                ⭐ PRO PLAN FEATURE
            </span>
        </div>
        <p class="text-gray-600 text-sm mt-2">Auto-generate tournament brackets for your sports events</p>
    </div>

    <!-- Generate Bracket Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Generate New Bracket</h2>

        @php
            $availableSports = $sports->filter(fn($s) => !$s->bracket);
        @endphp

        @if($availableSports->count() > 0)
            <form action="{{ route('tenant.brackets.generate', $university->slug) }}" method="POST" class="space-y-6" x-data="{ bracketType: '{{ old('bracket_type', 'single_elimination') }}' }">
                @csrf

                <!-- Sport Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sport</label>
                    <select name="sport_id" required class="w-full px-4 py-2 border @error('sport_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Select Sport --</option>
                        @foreach($availableSports as $sport)
                            <option value="{{ $sport->id }}" @selected(old('sport_id') == $sport->id)>
                                {{ $sport->name }} ({{ $sport->teams_count ?? 0 }} teams)
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Only sports without existing brackets shown</p>
                    @error('sport_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bracket Type Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bracket Type</label>
                    <select name="bracket_type" required x-model="bracketType" class="w-full px-4 py-2 border @error('bracket_type') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="single_elimination">Single Elimination</option>
                        <option value="double_elimination">Double Elimination</option>
                        <option value="round_robin">Round Robin</option>
                    </select>
                    @error('bracket_type')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bracket Type Description -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div x-show="bracketType === 'single_elimination'" class="text-sm text-blue-900">
                        <p class="font-medium">Single Elimination</p>
                        <p class="mt-1">Lose once and you're eliminated. Fast tournament with a clear winner.</p>
                    </div>

                    <div x-show="bracketType === 'double_elimination'" class="text-sm text-blue-900">
                        <p class="font-medium">Double Elimination</p>
                        <p class="mt-1">Teams need 2 losses to be eliminated. More games, fairer tournament outcome.</p>
                    </div>

                    <div x-show="bracketType === 'round_robin'" class="text-sm text-blue-900">
                        <p class="font-medium">Round Robin</p>
                        <p class="mt-1">Every team plays every other team. Best overall record wins the tournament.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        🎯 Generate Bracket
                    </button>
                </div>
            </form>
        @else
            <div class="p-6 text-center text-gray-500">
                <p>All sports already have brackets generated.</p>
            </div>
        @endif
    </div>

    <!-- Existing Brackets -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4">Existing Brackets</h2>

        @php
            $bracketsCount = $sports->filter(fn($s) => $s->bracket)->count();
        @endphp

        @if($bracketsCount > 0)
            <div class="space-y-4">
                @foreach($sports as $sport)
                    @if($sport->bracket)
                        @php
                            $bracket = $sport->bracket;
                            $totalMatches = $bracket->matches()->count();
                            $completedMatches = $bracket->matches()->whereNotNull('winner_id')->count();
                            $completionPercent = $totalMatches > 0 ? ($completedMatches / $totalMatches) * 100 : 0;

                            $bracketTypeColors = [
                                'single_elimination' => 'bg-orange-100 text-orange-800',
                                'double_elimination' => 'bg-red-100 text-red-800',
                                'round_robin' => 'bg-teal-100 text-teal-800',
                            ];
                            $bracketTypeColor = $bracketTypeColors[$bracket->type] ?? 'bg-gray-100 text-gray-800';

                            $statusColors = [
                                'active' => 'bg-green-100 text-green-800',
                                'completed' => 'bg-gray-100 text-gray-800',
                                'draft' => 'bg-yellow-100 text-yellow-800',
                            ];
                            $statusColor = $statusColors[$bracket->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp

                        <div class="bg-white rounded-lg shadow p-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $sport->name }}</h3>
                                    <div class="flex gap-2 mt-2">
                                        <span class="inline-block {{ $bracketTypeColor }} text-xs font-semibold px-2 py-1 rounded">
                                            {{ ucfirst(str_replace('_', ' ', $bracket->type)) }}
                                        </span>
                                        <span class="inline-block {{ $statusColor }} text-xs font-semibold px-2 py-1 rounded">
                                            {{ ucfirst($bracket->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                                <div class="text-center">
                                    <p class="text-xs text-gray-600">Total Matches</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $totalMatches }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs text-gray-600">Completed</p>
                                    <p class="text-2xl font-bold text-green-600">{{ $completedMatches }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs text-gray-600">Remaining</p>
                                    <p class="text-2xl font-bold text-orange-600">{{ $totalMatches - $completedMatches }}</p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-gray-600 font-medium">Completion</p>
                                    <p class="text-sm font-bold text-gray-900">{{ intval($completionPercent) }}%</p>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all" style="width: {{ $completionPercent }}%"></div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('tenant.brackets.show', [$university->slug, $sport->id]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                                    View Bracket
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
                    @endif
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                <p>No brackets created yet. Generate one above to get started!</p>
            </div>
        @endif
    </div>
</div>
