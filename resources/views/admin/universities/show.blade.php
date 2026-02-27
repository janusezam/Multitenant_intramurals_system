@extends('layouts.admin')
@section('title', 'University Details')

<div class="space-y-6">
    <!-- Top Card: University Info -->
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $university->name }}</h1>
                <div class="flex items-center gap-3 mt-2">
                    <code class="text-sm bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $university->slug }}</code>
                    @if($university->plan === 'pro')
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">PRO</span>
                    @else
                        <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">BASIC</span>
                    @endif
                    @if($university->is_active)
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Active</span>
                    @else
                        <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">Inactive</span>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.universities.toggleActive', $university) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 rounded font-medium @if($university->is_active) bg-green-100 text-green-800 hover:bg-green-200 @else bg-red-100 text-red-800 hover:bg-red-200 @endif">
                        @if($university->is_active) Deactivate @else Activate @endif
                    </button>
                </form>
                <a href="{{ route('admin.universities.edit', $university) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Edit
                </a>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 py-6 border-t border-gray-200">
            <div>
                <p class="text-xs uppercase text-gray-500 font-semibold">Email</p>
                <p class="text-gray-900 font-medium mt-1">{{ $university->email }}</p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-500 font-semibold">Plan Expires</p>
                <p class="text-gray-900 font-medium mt-1 @if($university->plan_expires_at && $university->plan_expires_at->isPast()) text-red-600 @endif">
                    {{ $university->plan_expires_at?->format('M d, Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-500 font-semibold">Created At</p>
                <p class="text-gray-900 font-medium mt-1">{{ $university->created_at->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase text-gray-500 font-semibold">Academic Year</p>
                <p class="text-gray-900 font-medium mt-1">{{ $university->subscription?->academic_year ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 py-6 border-t border-gray-200">
            <div>
                <p class="text-xs uppercase text-gray-500 font-semibold">Amount Paid</p>
                <p class="text-gray-900 font-medium mt-1">₱{{ number_format($university->subscription?->amount_paid ?? 0, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600">Total Users</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600">Total Sports</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_sports'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600">Total Teams</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_teams'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600">Total Players</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_players'] }}</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900">University Users ({{ $users->count() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->getRoleNames() as $role)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded capitalize">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                No users yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back Link -->
    <div>
        <a href="{{ route('admin.universities.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            ← Back to Universities
        </a>
    </div>
</div>
