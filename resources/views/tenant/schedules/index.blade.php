@extends('layouts.app')
@section('title', 'Schedules')
@section('content')

<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Game Schedules 📅</h1>
        @can('manage schedules')
            <a href="{{ route('tenant.schedules.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                + Schedule Game
            </a>
        @endcan
    </div>

    <!-- Filter Bar -->
    <form method="GET" class="bg-white rounded-lg shadow p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Filter by Sport -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sport</label>
                <select name="sport_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Sports</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}" @selected(request('sport_id') == $sport->id)>
                            {{ $sport->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="scheduled" @selected(request('status') === 'scheduled')>Scheduled</option>
                    <option value="ongoing" @selected(request('status') === 'ongoing')>Ongoing</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <!-- Filter by Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium">
                    Filter
                </button>
                <a href="{{ route('tenant.schedules.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Clear
                </a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Match</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Venue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($schedules as $schedule)
                        @php
                            $statusColors = [
                                'scheduled' => 'bg-blue-100 text-blue-800',
                                'ongoing' => 'bg-amber-100 text-amber-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-gray-100 text-gray-500 line-through',
                            ];
                            $statusColor = $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('M d') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $schedule->sport->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <span class="font-bold text-gray-900">{{ $schedule->homeTeam->name }}</span>
                                    <span class="text-gray-500 text-sm mx-2">vs</span>
                                    <span class="font-bold text-gray-900">{{ $schedule->awayTeam->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                📍 {{ $schedule->venue->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block {{ $statusColor }} text-xs font-semibold px-2 py-1 rounded">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('tenant.schedules.show', [$university->slug, $schedule]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    View
                                </a>

                                @can('manage schedules')
                                    @if(!in_array($schedule->status, ['completed', 'cancelled']))
                                        <a href="{{ route('tenant.schedules.edit', [$university->slug, $schedule]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            Edit
                                        </a>
                                    @endif
                                @endcan

                                @can('manage results')
                                    @if(!$schedule->matchResult && $schedule->status !== 'cancelled')
                                        <a href="{{ route('tenant.results.create', [$university->slug, $schedule]) }}" class="text-green-600 hover:text-green-800 font-medium">
                                            Record Result
                                        </a>
                                    @elseif($schedule->matchResult)
                                        <a href="{{ route('tenant.results.edit', [$university->slug, $schedule]) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">
                                            Edit Result
                                        </a>
                                    @endif
                                @endcan

                                @can('manage schedules')
                                    @if(!$schedule->matchResult && !in_array($schedule->status, ['ongoing', 'cancelled']))
                                        <form action="{{ route('tenant.schedules.destroy', [$university->slug, $schedule]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Are you sure?')) $event.preventDefault()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <p class="text-gray-500 mb-4">No games scheduled yet.</p>
                                @can('manage schedules')
                                    <a href="{{ route('tenant.schedules.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                                        + Schedule Game
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $schedules->links() }}
    </div>
</div>
@endsection
