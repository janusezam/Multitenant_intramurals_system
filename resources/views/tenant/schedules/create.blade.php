@extends('layouts.app')
@section('title', 'Schedule Game')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Schedule New Game</h1>

        <form action="{{ route('tenant.schedules.store', $university->slug) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Sport -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sport</label>
                <select name="sport_id" required class="w-full px-4 py-2 border @error('sport_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Sport --</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}" @selected(old('sport_id') == $sport->id)>
                            {{ $sport->name }}
                        </option>
                    @endforeach
                </select>
                @error('sport_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Home Team -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Home Team</label>
                <select name="home_team_id" required class="w-full px-4 py-2 border @error('home_team_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Home Team --</option>
                    @foreach($teams->groupBy('sport.name') as $sportName => $sportTeams)
                        <optgroup label="{{ $sportName }}">
                            @foreach($sportTeams as $team)
                                <option value="{{ $team->id }}" @selected(old('home_team_id') == $team->id)>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('home_team_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Away Team -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Away Team</label>
                <select name="away_team_id" required class="w-full px-4 py-2 border @error('away_team_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Away Team --</option>
                    @foreach($teams->groupBy('sport.name') as $sportName => $sportTeams)
                        <optgroup label="{{ $sportName }}">
                            @foreach($sportTeams as $team)
                                <option value="{{ $team->id }}" @selected(old('away_team_id') == $team->id)>
                                    {{ $team->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Must be different from home team</p>
                @error('away_team_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Venue -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                <select name="venue_id" required class="w-full px-4 py-2 border @error('venue_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select Venue --</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}" @selected(old('venue_id') == $venue->id)>
                            {{ $venue->name }}
                            @if($venue->capacity)
                                (Capacity: {{ $venue->capacity }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('venue_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date & Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date & Time</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" required class="w-full px-4 py-2 border @error('scheduled_at') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" id="datetimepicker">
                <p class="text-xs text-gray-500 mt-1">Games must be scheduled at least from tomorrow</p>
                @error('scheduled_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required class="w-full px-4 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="scheduled" @selected(old('status', 'scheduled') === 'scheduled')>Scheduled</option>
                    <option value="ongoing" @selected(old('status') === 'ongoing')>Ongoing</option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Conflict Warning -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-900">
                    <span class="font-medium">ℹ️ The system will automatically check for:</span>
                </p>
                <ul class="text-sm text-blue-900 mt-2 ml-6 space-y-1 list-disc">
                    <li>Venue conflicts (same venue, same time)</li>
                    <li>Team conflicts (same team, same time)</li>
                </ul>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.schedules.index', $university->slug) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Schedule Game
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#datetimepicker", {
        enableTime: true,
        minDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
        dateFormat: "Y-m-d H:i",
    });
</script>
@endsection
