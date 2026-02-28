@extends('layouts.app')
@section('title', 'Edit Team')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Team</h1>

        <!-- Info Box -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-900">
                <span class="font-medium">Editing:</span> {{ $team->name }}
            </p>
        </div>

        <form action="{{ route('tenant.teams.update', [$university->slug, $team]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Team Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Team Name</label>
                <input type="text" name="name" value="{{ old('name', $team->name) }}" required placeholder="e.g. College of Engineering" class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sport -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sport</label>
                <select name="sport_id" required class="w-full px-4 py-2 border @error('sport_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Sport --</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}" @selected(old('sport_id', $team->sport_id) == $sport->id)>
                            {{ $sport->name }} ({{ ucfirst($sport->category) }})
                        </option>
                    @endforeach
                </select>
                @error('sport_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Coach -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coach</label>
                <select name="coach_id" class="w-full px-4 py-2 border @error('coach_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- No Coach --</option>
                    @foreach($coaches as $coach)
                        <option value="{{ $coach->id }}" @selected(old('coach_id', $team->coach_id) == $coach->id)>
                            {{ $coach->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Optional - assign a team coach</p>
                @error('coach_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Plan Limit Info -->
            <div class="p-4 @if(app('current_university')->plan === 'basic') bg-blue-50 border border-blue-200 @else bg-green-50 border border-green-200 @endif rounded-lg">
                <p class="text-sm @if(app('current_university')->plan === 'basic') text-blue-900 @else text-green-900 @endif">
                    @if(app('current_university')->plan === 'basic')
                        <span class="font-medium">ℹ️ Basic Plan:</span> Maximum 10 teams per sport.
                    @else
                        <span class="font-medium">✅ Pro Plan:</span> Unlimited teams allowed.
                    @endif
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.teams.index', $university->slug) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Update Team
                </button>
            </div>
        </form>
    </div>
</div>
