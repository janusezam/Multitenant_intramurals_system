@extends('layouts.app')
@section('title', 'Teams')

<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Team Management 👥</h1>
        @can('manage teams')
            <a href="{{ route('tenant.teams.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                + Add Team
            </a>
        @endcan
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Team Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Coach</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Players</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($teams as $team)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('tenant.teams.show', [$university->slug, $team]) }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                                    {{ $team->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $team->sport->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($team->coach)
                                    <span class="text-gray-900">{{ $team->coach->name }}</span>
                                @else
                                    <span class="text-gray-500 italic">No coach assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $team->players_count ?? 0 }} players
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                @can('manage teams')
                                    <a href="{{ route('tenant.teams.edit', [$university->slug, $team]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        Edit
                                    </a>

                                    @if(($team->active_schedules_count ?? 0) === 0)
                                        <form action="{{ route('tenant.teams.destroy', [$university->slug, $team]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Are you sure?')) $event.preventDefault()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed" title="Cannot delete team with active schedules">
                                            Delete
                                        </span>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <p class="text-gray-500 mb-4">No teams registered yet.</p>
                                @can('manage teams')
                                    <a href="{{ route('tenant.teams.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                                        + Add Team
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
        {{ $teams->links() }}
    </div>
</div>
