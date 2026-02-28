@extends('layouts.app')
@section('title', 'Register Player')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Register Player</h1>

        <form action="{{ route('tenant.players.store', $university->slug) }}" method="POST" class="space-y-6">
            @csrf

            <!-- User Account -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">User Account</label>
                <select name="user_id" required class="w-full px-4 py-2 border @error('user_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select User --</option>
                    @foreach($availableUsers as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Only users not yet registered as players are shown here.</p>
                @error('user_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Team -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Team</label>
                <select name="team_id" required class="w-full px-4 py-2 border @error('team_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Team --</option>
                    @foreach($teams->groupBy('sport.name') as $sportName => $sportTeams)
                        <optgroup label="{{ $sportName }}">
                            @foreach($sportTeams as $team)
                                <option value="{{ $team->id }}" @selected(old('team_id') == $team->id)>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('team_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jersey Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jersey Number</label>
                <input type="text" name="jersey_number" value="{{ old('jersey_number') }}" maxlength="10" placeholder="e.g. 10, 23, 7" class="w-full px-4 py-2 border @error('jersey_number') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Must be unique within the team</p>
                @error('jersey_number')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                <input type="text" name="position" value="{{ old('position') }}" maxlength="50" placeholder="e.g. Point Guard, Setter, Forward" class="w-full px-4 py-2 border @error('position') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('position')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.players.index', $university->slug) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Register Player
                </button>
            </div>
        </form>
    </div>
</div>
