@extends('layouts.admin')
@section('title', 'Profile')
@section('content')

<div class="max-w-4xl mx-auto space-y-8">
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow p-8">
        <div class="flex items-start gap-6">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="w-24 h-24 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-4xl font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>

            <!-- Profile Info -->
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900">{{ auth()->user()->name }}</h1>
                <p class="text-gray-600 mt-1">{{ auth()->user()->email }}</p>

                <div class="flex items-center gap-3 mt-4">
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded">
                        Super Administrator
                    </span>
                </div>

                <p class="text-sm text-gray-600 mt-4">
                    <span class="font-medium">Member since:</span> {{ auth()->user()->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Update Profile Form -->
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Profile Information</h2>

        <!-- Success Message -->
        @if(session('status') === 'profile-updated')
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 font-medium">✅ Profile updated successfully!</p>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password Form -->
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Change Password</h2>

        <!-- Success Message -->
        @if(session('status') === 'password-updated')
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 font-medium">✅ Password updated successfully!</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required class="w-full px-4 py-2 border @error('current_password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Account Section -->
    <div class="bg-white rounded-lg shadow border-l-4 border-red-500 p-8">
        <h2 class="text-2xl font-bold text-red-900 mb-4">⚠️ Danger Zone</h2>
        <p class="text-gray-700 mb-6">
            Permanently delete your account and all associated data. This action cannot be undone.
        </p>

        <button type="button" @click="$dispatch('confirm-delete')" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition">
            Delete Account
        </button>

        <!-- Alpine.js Confirmation Modal -->
        <div x-data="{ 
            open: false, 
            password: ''
        }" x-on:confirm-delete="open = true" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-show="open">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="open = false"></div>

            <!-- Modal -->
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6" @click.stop>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Account</h3>
                    <p class="text-gray-600 mb-4">
                        Are you sure! Deleting your account is permanent and cannot be undone. Please enter your password to confirm.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                        @csrf
                        @method('DELETE')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" x-model="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="open = false" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">
                                Delete Permanently
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
