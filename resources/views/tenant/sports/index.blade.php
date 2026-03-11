@extends('layouts.app')
@section('title', 'Sports')
@section('content')

<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Sports Management 🏅</h1>
        @can('manage sports')
            <a href="{{ route('tenant.sports.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                + Add Sport
            </a>
        @endcan
    </div>

    <!-- Sports Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @forelse($sports as $sport)
            @php
                $statusColors = [
                    'upcoming' => 'bg-blue-50 border-blue-200',
                    'ongoing' => 'bg-green-50 border-green-200',
                    'completed' => 'bg-gray-50 border-gray-200',
                ];
                $statusColor = $statusColors[$sport->status] ?? 'bg-gray-50 border-gray-200';

                $categoryBadgeColor = $sport->category === 'team' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800';
                $categoryLabel = $sport->category === 'team' ? 'Team Sport' : 'Individual Sport';

                $bracketColors = [
                    'single_elimination' => 'bg-orange-100 text-orange-800',
                    'double_elimination' => 'bg-red-100 text-red-800',
                    'round_robin' => 'bg-teal-100 text-teal-800',
                ];
                $bracketColor = $bracketColors[$sport->bracket_type] ?? 'bg-gray-100 text-gray-800';
                $bracketLabel = str_replace('_', ' ', ucfirst($sport->bracket_type));

                $statusBadgeColor = [
                    'upcoming' => 'bg-blue-100 text-blue-800',
                    'ongoing' => 'bg-green-100 text-green-800',
                    'completed' => 'bg-gray-100 text-gray-800',
                ][$sport->status] ?? 'bg-gray-100 text-gray-800';
            @endphp

            <div class="bg-white rounded-lg shadow hover:shadow-lg transition border border-gray-200 {{ $statusColor }}">
                <div class="p-6 space-y-4">
                    <!-- Name and Status -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $sport->name }}</h3>
                        <div class="flex gap-2 mt-2">
                            <span class="inline-block {{ $categoryBadgeColor }} text-xs font-semibold px-2 py-1 rounded">
                                {{ $categoryLabel }}
                            </span>
                            <span class="inline-block {{ $bracketColor }} text-xs font-semibold px-2 py-1 rounded">
                                {{ $bracketLabel }}
                            </span>
                            <span class="inline-block {{ $statusBadgeColor }} text-xs font-semibold px-2 py-1 rounded capitalize">
                                {{ $sport->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-3 gap-3 py-3 border-y border-gray-200">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ $sport->teams_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600">Teams</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $sport->players_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600">Players</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $sport->schedules_count ?? 0 }}</p>
                            <p class="text-xs text-gray-600">Schedules</p>
                        </div>
                    </div>

                    <!-- Facilitator -->
                    <div class="text-sm">
                        @if($sport->facilitator)
                            <p class="text-gray-700">👤 {{ $sport->facilitator->name }}</p>
                        @else
                            <p class="text-gray-500">👤 No facilitator assigned</p>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="pt-4 border-t border-gray-200 flex items-center justify-between">
                        <a href="{{ route('tenant.sports.show', [$university->slug, $sport]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                            View Details
                        </a>

                        <div class="flex items-center gap-2">
                            @can('manage sports')
                                <a href="{{ route('tenant.sports.edit', [$university->slug, $sport]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('tenant.sports.destroy', [$university->slug, $sport]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Are you sure?')) $event.preventDefault()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <div class="text-6xl mb-4">🏅</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No sports added yet.</h3>
                    <p class="text-gray-600 mb-6">Start by adding your first sport to the intramurals program.</p>
                    @can('manage sports')
                        <a href="{{ route('tenant.sports.create', $university->slug) }}" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                            Add your first sport
                        </a>
                    @endcan
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
