@extends('layouts.app')
@section('title', 'Venues')
@section('content')

<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Venue Management 🏟️</h1>
        @can('manage venues')
            <a href="{{ route('tenant.venues.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                + Add Venue
            </a>
        @endcan
    </div>

    <!-- Venues Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @forelse($venues as $venue)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200">
                <div class="p-6 space-y-4">
                    <!-- Name -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $venue->name }}</h3>
                    </div>

                    <!-- Location -->
                    <div class="text-sm text-gray-600">
                        📍 {{ $venue->location ?? 'Location not specified' }}
                    </div>

                    <!-- Capacity -->
                    <div class="text-sm text-gray-600">
                        👥 {{ $venue->capacity ? 'Capacity: ' . number_format($venue->capacity) . ' people' : 'Capacity not set' }}
                    </div>

                    <!-- Schedules count -->
                    <div class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded">
                        {{ $venue->schedules_count ?? 0 }} games scheduled
                    </div>

                    <!-- Footer -->
                    <div class="pt-4 border-t border-gray-200 flex items-center justify-between">
                        <a href="{{ route('tenant.venues.show', [$university->slug, $venue]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                            View Schedule
                        </a>

                        <div class="flex items-center gap-2">
                            @can('manage venues')
                                <a href="{{ route('tenant.venues.edit', [$university->slug, $venue]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    Edit
                                </a>

                                @if(($venue->schedules_count ?? 0) === 0)
                                    <form action="{{ route('tenant.venues.destroy', [$university->slug, $venue]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Are you sure?')) $event.preventDefault()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm cursor-not-allowed" title="Cannot delete venue with scheduled games">
                                        Delete
                                    </span>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <div class="text-6xl mb-4">🏟️</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No venues added yet.</h3>
                    <p class="text-gray-600 mb-6">Start by adding your first venue to host intramural games.</p>
                    @can('manage venues')
                        <a href="{{ route('tenant.venues.create', $university->slug) }}" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                            Add your first venue
                        </a>
                    @endcan
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
