@extends('layouts.app')
@section('title', 'Players')

<div class="space-y-6">
    <!-- Plan Limit Notice -->
    @php
        $plan = app('current_university')->plan;
        $totalPlayers = $players->total();
        $limit = $plan === 'basic' ? 200 : null;
        $percentage = $limit ? ($totalPlayers / $limit) * 100 : 0;
        $statusColor = $percentage >= 180 ? 'red' : ($percentage >= 150 ? 'yellow' : 'green');
    @endphp

    <div class="@if($statusColor === 'red') bg-red-50 border border-red-200 @elseif($statusColor === 'yellow') bg-yellow-50 border border-yellow-200 @else bg-green-50 border border-green-200 @endif rounded-lg p-4">
        <p class="@if($statusColor === 'red') text-red-900 @elseif($statusColor === 'yellow') text-yellow-900 @else text-green-900 @endif font-medium">
            @if($plan === 'basic')
                Players: <span class="font-bold">{{ $totalPlayers }}/200</span> (Basic Plan Limit)
            @else
                ✅ Players: <span class="font-bold">{{ $totalPlayers }}</span> (Unlimited - Pro Plan)
            @endif
        </p>
        @if($plan === 'basic' && $limit)
            <div class="mt-2 bg-gray-200 rounded-full h-2">
                <div class="@if($statusColor === 'red') bg-red-600 @elseif($statusColor === 'yellow') bg-yellow-600 @else bg-green-600 @endif h-2 rounded-full transition-all" style="width: {{ min($percentage, 100) }}%"></div>
            </div>
        @endif
    </div>

    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Player Registry 🎽</h1>
        @can('manage players')
            <a href="{{ route('tenant.players.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                + Register Player
            </a>
        @endcan
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Jersey #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Player Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Team</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($players as $player)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                @if($player->jersey_number)
                                    <span class="inline-block bg-indigo-600 text-white font-bold w-8 h-8 rounded-full flex items-center justify-center text-xs">
                                        {{ $player->jersey_number }}
                                    </span>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                {{ $player->user->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">
                                {{ $player->user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if($player->team)
                                    <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ $player->team->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500 italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($player->team && $player->team->sport)
                                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ $player->team->sport->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $player->position ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('tenant.players.show', [$university->slug, $player]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    View
                                </a>
                                @can('manage players')
                                    <a href="{{ route('tenant.players.edit', [$university->slug, $player]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('tenant.players.destroy', [$university->slug, $player]) }}" method="POST" class="inline" x-data x-on:submit="if (!confirm('Remove this player?')) $event.preventDefault()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                            Remove
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <p class="text-gray-500 mb-4">No players registered yet.</p>
                                @can('manage players')
                                    <a href="{{ route('tenant.players.create', $university->slug) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                                        + Register Player
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
        {{ $players->links() }}
    </div>
</div>
