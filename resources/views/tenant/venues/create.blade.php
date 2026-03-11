@extends('layouts.app')
@section('title', 'Add Venue')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Add New Venue</h1>

        <form action="{{ route('tenant.venues.store', $university->slug) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Venue Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Venue Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Main Gymnasium, Covered Court A" class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. UST Main Campus, Building A" class="w-full px-4 py-2 border @error('location') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Physical location or building name</p>
                @error('location')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" placeholder="e.g. 500" class="w-full px-4 py-2 border @error('capacity') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Maximum number of spectators/participants</p>
                @error('capacity')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tenant.venues.index', $university->slug) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Add Venue
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
