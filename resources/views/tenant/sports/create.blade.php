@extends('layouts.app')
@section('title', 'Add Sport')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Add New Sport</h1>

        <form action="{{ route('tenant.sports.store', $university->slug) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Sport Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sport Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Basketball, Volleyball" class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" required class="w-full px-4 py-2 border @error('category') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select category --</option>
                    <option value="team" @selected(old('category') === 'team')>Team Sport</option>
                    <option value="individual" @selected(old('category') === 'individual')>Individual Sport</option>
                </select>
                <div class="mt-2 grid grid-cols-2 gap-4 text-xs text-gray-600">
                    <div>
                        <p class="font-medium">Team:</p>
                        <p>Multiple players compete as a team</p>
                    </div>
                    <div>
                        <p class="font-medium">Individual:</p>
                        <p>Players compete individually</p>
                    </div>
                </div>
                @error('category')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bracket Type -->
            <div x-data="{ bracketType: '{{ old('bracket_type') }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bracket Type</label>
                <select name="bracket_type" x-model="bracketType" required class="w-full px-4 py-2 border @error('bracket_type') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select bracket type --</option>
                    <option value="single_elimination" @selected(old('bracket_type') === 'single_elimination')>Single Elimination</option>
                    <option value="double_elimination" @selected(old('bracket_type') === 'double_elimination')>Double Elimination</option>
                    <option value="round_robin" @selected(old('bracket_type') === 'round_robin')>Round Robin</option>
                </select>

                <div class="mt-2 space-y-2 text-xs text-gray-600">
                    <div x-show="bracketType === 'single_elimination'" class="p-2 bg-orange-50 rounded">
                        <p class="font-medium">Single Elimination:</p>
                        <p>Lose once and you're out</p>
                    </div>
                    <div x-show="bracketType === 'double_elimination'" class="p-2 bg-red-50 rounded">
                        <p class="font-medium">Double Elimination:</p>
                        <p>Two losses to be eliminated</p>
                    </div>
                    <div x-show="bracketType === 'round_robin'" class="p-2 bg-teal-50 rounded">
                        <p class="font-medium">Round Robin:</p>
                        <p>Every team plays every other team</p>
                    </div>
                </div>

                @error('bracket_type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Facilitator -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Facilitator</label>
                <select name="facilitator_id" class="w-full px-4 py-2 border @error('facilitator_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- No Facilitator --</option>
                    @foreach($facilitators as $facilitator)
                        <option value="{{ $facilitator->id }}" @selected(old('facilitator_id') == $facilitator->id)>
                            {{ $facilitator->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Assign a sports facilitator to manage this sport</p>
                @error('facilitator_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" required class="w-full px-4 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Select status --</option>
                    <option value="upcoming" @selected(old('status') === 'upcoming')>Upcoming</option>
                    <option value="ongoing" @selected(old('status') === 'ongoing')>Ongoing</option>
                    <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.sports.index', $university->slug) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Create Sport
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
