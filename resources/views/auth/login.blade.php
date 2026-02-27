<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ISMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white flex-col justify-between p-12">
            <div>
                <div class="text-4xl font-bold mb-2">🏆 ISMS</div>
                <p class="text-xl text-indigo-100">Your University Intramurals, Centrally Managed.</p>
            </div>

            <ul class="space-y-4 text-lg">
                <li class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <span>Multi-sport management</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <span>Team & player registry</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <span>Game scheduling</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <span>Live standings</span>
                </li>
                <li class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <span>Analytics & brackets (Pro)</span>
                </li>
            </ul>

            <div>
                <a href="/" class="text-indigo-200 hover:text-white font-medium">← Back to Home</a>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Welcome Back!</h1>
                    <p class="text-gray-600 mt-2">Login to your university dashboard</p>
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

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-right">
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition">
                        Login
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center gap-4">
                    <div class="flex-1 h-px bg-gray-300"></div>
                    <span class="text-gray-500 text-sm">or</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>

                <!-- Register Link -->
                <p class="text-center text-gray-700">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Register here
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
