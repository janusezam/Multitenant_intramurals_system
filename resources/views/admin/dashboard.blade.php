@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Universities -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="text-sm text-gray-600">Total Universities</div>
            <div class="text-3xl font-bold text-blue-700 mt-2">{{ $stats['total_universities'] }}</div>
        </div>

        <!-- Active Universities -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="text-sm text-gray-600">Active Universities</div>
            <div class="text-3xl font-bold text-green-700 mt-2">{{ $stats['active_universities'] }}</div>
        </div>

        <!-- Basic Plan -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-gray-500">
            <div class="text-sm text-gray-600">Basic Plan</div>
            <div class="text-3xl font-bold text-gray-700 mt-2">{{ $stats['basic_plan'] }}</div>
        </div>

        <!-- Pro Plan -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="text-sm text-gray-600">Pro Plan</div>
            <div class="text-3xl font-bold text-yellow-700 mt-2">{{ $stats['pro_plan'] }}</div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <div class="text-sm text-gray-600">Total Users</div>
            <div class="text-3xl font-bold text-indigo-700 mt-2">{{ $stats['total_users'] }}</div>
        </div>

        <!-- Total Sports -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="text-sm text-gray-600">Total Sports</div>
            <div class="text-3xl font-bold text-purple-700 mt-2">{{ $stats['total_sports'] }}</div>
        </div>

        <!-- Total Players -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-pink-500">
            <div class="text-sm text-gray-600">Total Players</div>
            <div class="text-3xl font-bold text-pink-700 mt-2">{{ $stats['total_players'] }}</div>
        </div>

        <!-- Expiring Soon -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="text-sm text-gray-600">Expiring Soon</div>
            <div class="text-3xl font-bold text-red-700 mt-2">{{ $stats['expiring_soon'] }}</div>
        </div>
    </div>

    <!-- Recent Universities Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">Recently Registered Universities</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">University Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Expires At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentUniversities as $university)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">{{ $university->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $university->slug }}</code>
                            </td>
                            <td class="px-6 py-4">
                                @if($university->plan === 'pro')
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">PRO</span>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">BASIC</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($university->is_active)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Active</span>
                                @else
                                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($university->plan_expires_at && $university->plan_expires_at->isPast())
                                    <span class="text-red-600 font-semibold">{{ $university->plan_expires_at->format('M d, Y') }}</span>
                                @else
                                    <span class="text-gray-700">{{ $university->plan_expires_at?->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.universities.show', $university) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No universities yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expiring Soon Warning -->
    @if($expiringUniversities->count() > 0)
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-red-900 mb-4">⚠️ Universities Expiring Within 30 Days</h3>
            <div class="space-y-3">
                @foreach($expiringUniversities as $university)
                    <div class="flex items-center justify-between bg-white p-4 rounded">
                        <div>
                            <p class="font-medium text-gray-900">{{ $university->name }}</p>
                            <p class="text-sm text-red-700 font-bold">Expires: {{ $university->plan_expires_at->format('M d, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($university->plan === 'pro')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">PRO</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">BASIC</span>
                            @endif
                            <a href="{{ route('admin.subscriptions.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Manage Subscription
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
