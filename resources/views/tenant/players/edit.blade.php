@extends('layouts.app')
@section('title', 'Edit Player')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Player</h1>

        <form action="{{ route('tenant.players.update', [$university->slug, $player]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- User Account (Read-Only) -->
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <p class="text-sm text-gray-700">
                    👤 <span class="font-medium">Player Account:</span> {{ $player->user->name }} ({{ $player->user->email }})
                </p>
                <p class="text-xs text-gray-500 mt-2">User account cannot be changed after registration.</p>
            </div>

            <!-- Team -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Team</label>
                <select name="team_id" required class="w-full px-4 py-2 border @error('team_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Team --</option>
                    @foreach($teams->groupBy('sport.name') as $sportName => $sportTeams)
                        <optgroup label="{{ $sportName }}">
                            @foreach($sportTeams as $team)
                                <option value="{{ $team->id }}" @selected(old('team_id', $player->team_id) == $team->id)>
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
                <input type="text" name="jersey_number" value="{{ old('jersey_number', $player->jersey_number) }}" maxlength="10" placeholder="e.g. 10, 23, 7" class="w-full px-4 py-2 border @error('jersey_number') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Must be unique within the team</p>
                @error('jersey_number')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Position -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                <input type="text" name="position" value="{{ old('position', $player->position) }}" maxlength="50" placeholder="e.g. Point Guard, Setter, Forward" class="w-full px-4 py-2 border @error('position') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                    Update Player
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
