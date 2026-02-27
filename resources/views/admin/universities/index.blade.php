@extends('layouts.admin')
@section('title', 'Universities')

<div class="space-y-6">
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">All Universities</h1>
        <a href="{{ route('admin.universities.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
            + Add University
        </a>
    </div>

    <!-- Search/Filter Bar -->
    <form method="GET" action="{{ route('admin.universities.index') }}" class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or slug..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                <select name="plan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Plans</option>
                    <option value="basic" @selected(request('plan') === 'basic')>Basic</option>
                    <option value="pro" @selected(request('plan') === 'pro')>Pro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Filter
                </button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">University Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Expires At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Users</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($universities as $university)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900">{{ $university->id }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.universities.show', $university) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                    {{ $university->name }}
                                </a>
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
                                <form action="{{ route('admin.universities.toggleActive', $university) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-block px-3 py-1 rounded text-xs font-semibold @if($university->is_active) bg-green-100 text-green-800 hover:bg-green-200 @else bg-red-100 text-red-800 hover:bg-red-200 @endif">
                                        @if($university->is_active) Active @else Inactive @endif
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if($university->plan_expires_at && $university->plan_expires_at->isPast())
                                    <span class="text-red-600 font-semibold">{{ $university->plan_expires_at->format('M d, Y') }}</span>
                                @elseif($university->plan_expires_at && $university->plan_expires_at->diffInDays(now()) <= 30)
                                    <span class="text-yellow-600 font-semibold">{{ $university->plan_expires_at->format('M d, Y') }}</span>
                                @else
                                    <span class="text-gray-700">{{ $university->plan_expires_at?->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900">{{ $university->users()->count() }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.universities.show', $university) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    View
                                </a>
                                <a href="{{ route('admin.universities.edit', $university) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Edit
                                </a>
                                @if($university->users()->count() === 0)
                                    <form action="{{ route('admin.universities.destroy', $university) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 cursor-not-allowed" title="Cannot delete university with users">
                                        Delete
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                No universities found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $universities->links() }}
    </div>
</div>
