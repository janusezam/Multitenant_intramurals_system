@extends('layouts.app')
@section('title', $venue->name)

<div class="space-y-6">
    <!-- Venue Header -->
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">🏟️ {{ $venue->name }}</h1>

                <div class="space-y-2 mt-4">
                    <p class="text-gray-700">
                        <span class="font-medium">📍 Location:</span>
                        {{ $venue->location ?? 'Not specified' }}
                    </p>
                    <p class="text-gray-700">
                        <span class="font-medium">👥 Capacity:</span>
                        {{ $venue->capacity ? number_format($venue->capacity) . ' people' : 'Not set' }}
                    </p>
                </div>

                <div class="mt-4">
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded">
                        {{ $schedules->count() }} total schedules
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                @can('manage venues')
                    <a href="{{ route('tenant.venues.edit', [$university->slug, $venue]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('tenant.venues.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Upcoming Schedule Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Upcoming Games at this Venue 📅</h2>
        </div>

        @if($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Match</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ $schedule->sport->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-900">
                                        {{ $schedule->homeTeam->name }} vs {{ $schedule->awayTeam->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $schedule->scheduled_at->format('M d, Y · h:i A') }}</td>
                                <td class="px-6 py-4">
                                    @if($schedule->status === 'scheduled')
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">Scheduled</span>
                                    @elseif($schedule->status === 'ongoing')
                                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Ongoing</span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">Completed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('tenant.schedules.show', [$university->slug, $schedule]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                        View Game
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="text-4xl mb-3">🎉</div>
                <p class="text-gray-500">No upcoming games at this venue.</p>
            </div>
        @endif
    </div>
</div>
