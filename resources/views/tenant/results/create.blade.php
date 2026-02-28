@extends('layouts.app')
@section('title', 'Record Result')

<div class="max-w-2xl mx-auto">
    <!-- Game Info Card -->
    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-sm font-medium text-gray-700 mb-4">Recording Result For</h2>

        <div class="text-center space-y-3">
            <div class="flex gap-3 justify-center">
                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded">
                    {{ $schedule->sport->name }}
                </span>
            </div>

            <div class="flex items-center justify-center gap-4">
                <p class="font-bold text-gray-900">{{ $schedule->homeTeam->name }}</p>
                <p class="text-gray-500">vs</p>
                <p class="font-bold text-gray-900">{{ $schedule->awayTeam->name }}</p>
            </div>

            <div class="text-sm text-gray-600">
                📍 {{ $schedule->venue->name }} · 📅 {{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('D, M d Y · h:i A') }}
            </div>
        </div>
    </div>

    <!-- Result Form -->
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Record Match Result</h1>

        <form action="{{ route('tenant.results.store', [$university->slug, $schedule]) }}" method="POST" class="space-y-6" x-data="{ homeScore: {{ old('home_score', 0) }}, awayScore: {{ old('away_score', 0) }} }">
            @csrf

            <!-- Score Inputs -->
            <div class="grid grid-cols-5 gap-4 items-end">
                <!-- Home Score -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $schedule->homeTeam->name }} Score</label>
                    <input type="number" name="home_score" min="0" value="{{ old('home_score', 0) }}" required x-model.number="homeScore" class="w-full px-4 py-3 border @error('home_score') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center text-2xl font-bold" placeholder="0">
                    @error('home_score')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Separator -->
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-500">:</p>
                </div>

                <!-- Away Score -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $schedule->awayTeam->name }} Score</label>
                    <input type="number" name="away_score" min="0" value="{{ old('away_score', 0) }}" required x-model.number="awayScore" class="w-full px-4 py-3 border @error('away_score') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center text-2xl font-bold" placeholder="0">
                    @error('away_score')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Live Winner Preview -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                <p class="text-sm text-blue-900 font-medium">
                    <span x-show="homeScore > awayScore">🏆 Winner: {{ $schedule->homeTeam->name }}</span>
                    <span x-show="awayScore > homeScore">🏆 Winner: {{ $schedule->awayTeam->name }}</span>
                    <span x-show="homeScore === awayScore">🤝 Draw</span>
                </p>
            </div>

            <!-- Remarks -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea name="remarks" rows="4" maxlength="500" placeholder="Optional: Any notes about the game..." class="w-full px-4 py-2 border @error('remarks') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.schedules.show', [$university->slug, $schedule]) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                    Record Result
                </button>
            </div>
        </form>
    </div>
</div>
