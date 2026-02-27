@extends('layouts.admin')
@section('title', 'Edit University')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit University</h1>

        <!-- Current Subscription Info -->
        <div class="mb-8 p-4 bg-gray-100 rounded-lg">
            <p class="text-sm text-gray-700">
                <span class="font-medium">Current Plan:</span>
                @if($university->plan === 'pro')
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded ml-2">PRO</span>
                @else
                    <span class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-2 py-1 rounded ml-2">BASIC</span>
                @endif
                <span class="ml-4">| <span class="font-medium">Expires:</span> {{ $university->plan_expires_at?->format('M d, Y') }}</span>
                <span class="ml-4">| <span class="font-medium">Academic Year:</span> {{ $university->subscription?->academic_year ?? 'N/A' }}</span>
            </p>
        </div>

        <form action="{{ route('admin.universities.update', $university) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- University Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">University Name</label>
                <input type="text" name="name" value="{{ old('name', $university->name) }}" required class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $university->slug) }}" required x-data x-model="slug" class="w-full px-4 py-2 border @error('slug') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-2">Only lowercase letters, numbers, and hyphens. This will be used in URLs: /<span x-text="slug"></span>/dashboard</p>
                @error('slug')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $university->email) }}" required class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Plan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                <select name="plan" required class="w-full px-4 py-2 border @error('plan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="basic" @selected(old('plan', $university->plan) === 'basic')>Basic</option>
                    <option value="pro" @selected(old('plan', $university->plan) === 'pro')>Pro</option>
                </select>
                <div class="mt-2 grid grid-cols-2 gap-4 text-xs text-gray-600">
                    <div>
                        <p class="font-medium">Basic:</p>
                        <p>Up to 5 sports, 200 players, 50 users</p>
                    </div>
                    <div>
                        <p class="font-medium">Pro:</p>
                        <p>Unlimited everything + Analytics + Brackets</p>
                    </div>
                </div>
                @error('plan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Plan Expires At -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan Expires At</label>
                <input type="date" name="plan_expires_at" value="{{ old('plan_expires_at', $university->plan_expires_at?->format('Y-m-d')) }}" required class="w-full px-4 py-2 border @error('plan_expires_at') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-2">This is the subscription expiry date</p>
                @error('plan_expires_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.universities.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Update University
                </button>
            </div>
        </form>
    </div>
</div>
