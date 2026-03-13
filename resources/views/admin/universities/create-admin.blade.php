@extends('layouts.admin')
@section('title', 'Create Admin Account')

@section('content')
<div class="space-y-6">
    {{-- BACK LINK --}}
    <div>
        <a href="{{ route('admin.universities.show', $university) }}" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
            ← Back to {{ $university->name }}
        </a>
    </div>

    {{-- UNIVERSITY INFO CARD --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center text-2xl flex-shrink-0">
                🏫
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ $university->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-gray-600">/{{ $university->slug }}/</span>
                    @if($university->plan === 'pro')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">⭐ PRO</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">BASIC</span>
                    @endif
                    @if($university->is_active)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">✅ Active</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- CREATE ADMIN FORM --}}
    <div class="max-w-lg">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-base font-bold text-gray-900">👑 Create University Admin Account</h3>
                <p class="text-sm text-gray-600 mt-0.5">This person will have full control over {{ $university->name }}'s ISMS.</p>
            </div>

            <div class="p-6">
                {{-- VALIDATION ERRORS --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-sm font-semibold text-red-800 mb-2">Please fix the following:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-sm text-red-700">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.universities.store-admin', $university) }}">
                    @csrf

                    {{-- NAME --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Full Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="e.g. Juan dela Cruz"
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-gray-400 @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email Address
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="e.g. admin@mapua.edu.ph"
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-gray-400 @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-4" x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                :type="show ? 'text' : 'password'"
                                name="password"
                                placeholder="Min. 8 characters"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 bg-white pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-gray-400 @error('password') border-red-300 @enderror">
                            <button type="button"
                                    x-on:click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">
                                <span x-text="show ? '🙈' : '👁️'"></span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-6" x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Confirm Password
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                :type="show ? 'text' : 'password'"
                                name="password_confirmation"
                                placeholder="Repeat password"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-900 bg-white pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder:text-gray-400">
                            <button type="button"
                                    x-on:click="show = !show"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs">
                                <span x-text="show ? '🙈' : '👁️'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- INFO BOX --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-xs text-blue-700">
                            ℹ️ The admin will use these credentials to login at <strong>/login</strong> and will be redirected to <strong>/{{ $university->slug }}/dashboard</strong>
                        </p>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition-colors">
                            👑 Create Admin Account
                        </button>
                        <a href="{{ route('admin.universities.show', $university) }}"
                           class="flex-1 text-center border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2.5 rounded-lg transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
