@extends('layouts.app')
@section('title', $player->user->name)
@section('content')

<div class="space-y-6">
    <!-- Player Header -->
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                        {{ substr($player->user->name, 0, 1) }}
                    </div>
                </div>

                <!-- Info -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $player->user->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $player->user->email }}</p>

                    <div class="flex gap-3 mt-4">
                        @if($player->jersey_number)
                            <span class="inline-block bg-indigo-600 text-white font-bold w-12 h-12 rounded-full flex items-center justify-center">
                                {{ $player->jersey_number }}
                            </span>
                        @else
                            <span class="inline-block bg-gray-200 text-gray-600 px-3 py-1 rounded text-sm">No Jersey #</span>
                        @endif

                        @if($player->position)
                            <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded">
                                {{ $player->position }}
                            </span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded">No position assigned</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex gap-2">
                @can('manage players')
                    <a href="{{ route('tenant.players.edit', [$university->slug, $player]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('tenant.players.index', $university->slug) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Back
                </a>
            </div>
        </div>
    </div>

    <!-- Team Info Card -->
    @if($player->team)
        <div class="bg-white rounded-lg shadow p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Current Team 👥</h2>

            <div class="space-y-3">
                <p class="text-2xl font-bold text-indigo-600">{{ $player->team->name }}</p>

                <div class="flex gap-3">
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded">
                        {{ $player->team->sport->name }}
                    </span>

                    @if($player->team->coach)
                        <span class="text-gray-700">👤 Coach: {{ $player->team->coach->name }}</span>
                    @else
                        <span class="text-gray-500">👤 No coach assigned</span>
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <a href="{{ route('tenant.teams.show', [$university->slug, $player->team]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        View Team →
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Player Info Card -->
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Player Info</h2>

        <div class="space-y-4">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <p class="text-gray-600">Registered since</p>
                <p class="font-medium text-gray-900">{{ $player->created_at->format('M d, Y') }}</p>
            </div>

            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <p class="text-gray-600">University</p>
                <p class="font-medium text-gray-900">{{ $university->name }}</p>
            </div>

            <div class="flex justify-between items-center">
                <p class="text-gray-600">Role</p>
                <p class="font-medium text-gray-900">{{ $player->user->getRoleNames()->first() ?? 'Player' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
