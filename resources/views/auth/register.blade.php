<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ISMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <!-- Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="text-4xl font-bold">🏆</div>
                <h1 class="text-2xl font-bold text-gray-900 mt-4">Create Your Account</h1>
                <p class="text-gray-600 mt-2">Join your university's intramurals platform</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 font-medium mb-2">Please check the errors below:</p>
                    <ul class="text-red-700 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Juan Dela Cruz">
                </div>

                <!-- Email Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="your@email.com">
                </div>

                <!-- University -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">University</label>
                    <select name="university_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Select your university --</option>
                        @foreach($universities as $u)
                            <option value="{{ $u->id }}" @selected(old('university_id') == $u->id)>
                                {{ $u->name }} ({{ strtoupper($u->plan) }} PLAN)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Select your role --</option>
                        <option value="sports-facilitator" @selected(old('role') === 'sports-facilitator')>Sports Facilitator</option>
                        <option value="team-coach" @selected(old('role') === 'team-coach')>Team Coach</option>
                        <option value="student-player" @selected(old('role') === 'student-player')>Student Player</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">University admins are created by administrators only.</p>
                </div>

                <!-- Password -->
                <div x-data="{ showPassword: false }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-gray-500">
                            <span x-show="!showPassword">👁️</span>
                            <span x-show="showPassword">👁️‍🗨️</span>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div x-data="{ showPassword: false }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-gray-500">
                            <span x-show="!showPassword">👁️</span>
                            <span x-show="showPassword">👁️‍🗨️</span>
                        </button>
                    </div>
                </div>

                <!-- Plan Limit Note -->
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <span class="font-medium">ℹ️ Plan Limits:</span> Basic Plan universities are limited to 50 users. Pro Plan universities have unlimited users.
                    </p>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition">
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center gap-4">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span class="text-gray-500 text-sm">or</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>

            <!-- Login Link -->
            <p class="text-center text-gray-700">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Login here
                </a>
            </p>
        </div>
    </div>
</body>
</html>
