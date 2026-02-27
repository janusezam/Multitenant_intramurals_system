@extends('layouts.admin')
@section('title', 'Edit Subscription')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Subscription</h1>

        <!-- University Info -->
        <div class="mb-8 p-4 bg-gray-100 rounded-lg">
            <p class="text-sm text-gray-700">
                <span class="font-medium">University:</span>
                <span class="ml-2">{{ $subscription->university->name }}</span>
                <span class="ml-4">| <span class="font-medium">Current Plan:</span>
                @if($subscription->university->plan === 'pro')
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded ml-2">PRO</span>
                @else
                    <span class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-2 py-1 rounded ml-2">BASIC</span>
                @endif
                <span class="ml-4">| <span class="font-medium">Current Expiry:</span> {{ $subscription->expires_at->format('M d, Y') }}</span>
            </p>
        </div>

        <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Plan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                <select name="plan" required class="w-full px-4 py-2 border @error('plan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="basic" @selected(old('plan', $subscription->plan) === 'basic')>Basic</option>
                    <option value="pro" @selected(old('plan', $subscription->plan) === 'pro')>Pro</option>
                </select>
                @error('plan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Academic Year -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Academic Year</label>
                <input type="text" name="academic_year" value="{{ old('academic_year', $subscription->academic_year) }}" placeholder="e.g. 2025-2026" class="w-full px-4 py-2 border @error('academic_year') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('academic_year')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Expires At -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expires At</label>
                <input type="date" name="expires_at" value="{{ old('expires_at', $subscription->expires_at->format('Y-m-d')) }}" required class="w-full px-4 py-2 border @error('expires_at') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('expires_at')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount Paid -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount Paid</label>
                <div class="relative">
                    <span class="absolute left-4 top-2 text-gray-500 font-medium">₱</span>
                    <input type="number" name="amount_paid" value="{{ old('amount_paid', $subscription->amount_paid) }}" step="0.01" min="0" class="w-full pl-8 pr-4 py-2 border @error('amount_paid') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                @error('amount_paid')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Warning -->
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <span class="font-semibold">⚠️ Important:</span> Changing the plan will immediately affect what features the university can access.
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.subscriptions.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium">
                    Update Subscription
                </button>
            </div>
        </form>
    </div>
</div>
