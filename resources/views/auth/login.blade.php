<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ISMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen">
        <!-- LEFT PANEL -->
        <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between p-12 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 overflow-hidden">

            <!-- BACKGROUND DECORATION -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Large blur circle top right -->
                <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-indigo-500/10 blur-3xl">
                </div>
                <!-- Medium blur circle bottom left -->
                <div class="absolute -bottom-40 -left-20 w-80 h-80 rounded-full bg-purple-500/10 blur-3xl">
                </div>
                <!-- Small accent circle middle -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-indigo-400/5 blur-2xl">
                </div>
                <!-- Grid pattern overlay -->
                <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 40px 40px;">
                </div>
            </div>

            <!-- TOP: LOGO + BRAND -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <!-- Clean geometric logo mark -->
                    <div class="w-10 h-10 rounded-xl bg-indigo-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-indigo-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-bold text-xl tracking-tight">ISMS</span>
                        <span class="block text-indigo-300 text-xs font-medium tracking-widest uppercase">Intramurals Management</span>
                    </div>
                </div>
            </div>

            <!-- MIDDLE: HEADLINE + FEATURES -->
            <div class="relative z-10">
                <!-- Main headline -->
                <h1 class="text-4xl font-bold text-white leading-tight tracking-tight mb-4">
                    Manage Your<br>
                    University Sports<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">
                        Smarter.
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-slate-400 text-base leading-relaxed mb-10 max-w-sm">
                    The all-in-one platform for university intramural sports — from scheduling to live standings.
                </p>

                <!-- Feature list — clean, no emojis -->
                <div class="space-y-3">
                    <!-- Feature 1 -->
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center flex-shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400">
                            </div>
                        </div>
                        <span class="text-slate-300 text-sm">
                            Multi-sport tournament management
                        </span>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center flex-shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400">
                            </div>
                        </div>
                        <span class="text-slate-300 text-sm">
                            Team & player registry
                        </span>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center flex-shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400">
                            </div>
                        </div>
                        <span class="text-slate-300 text-sm">
                            Live standings & bracket generator
                        </span>
                    </div>

                    <!-- Feature 4 -->
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center flex-shrink-0">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400">
                            </div>
                        </div>
                        <span class="text-slate-300 text-sm">
                            Analytics & reports
                            <span class="text-xs bg-amber-500/20 text-amber-400 px-1.5 py-0.5 rounded-full ml-1">
                                PRO
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- BOTTOM: STATS ROW + BACK LINK -->
            <div class="relative z-10">
                <!-- Social proof stats -->
                <div class="flex items-center gap-6 pb-6 mb-6 border-b border-slate-700/50">
                    <div class="text-center">
                        <p class="text-white font-bold text-lg leading-none">
                            3+
                        </p>
                        <p class="text-slate-500 text-xs mt-1 leading-none">
                            Universities
                        </p>
                    </div>
                    <div class="w-px h-8 bg-slate-700">
                    </div>
                    <div class="text-center">
                        <p class="text-white font-bold text-lg leading-none">
                            50+
                        </p>
                        <p class="text-slate-500 text-xs mt-1 leading-none">
                            Teams
                        </p>
                    </div>
                    <div class="w-px h-8 bg-slate-700">
                    </div>
                    <div class="text-center">
                        <p class="text-white font-bold text-lg leading-none">
                            500+
                        </p>
                        <p class="text-slate-500 text-xs mt-1 leading-none">
                            Players
                        </p>
                    </div>
                </div>

                <!-- Back to home link -->
                <a href="{{ route('home') ?? '/' }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-300 text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900">Welcome Back!</h1>
                    <p class="text-slate-600 mt-2">Login to your university dashboard</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 border border-red-200 rounded-lg">
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
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-white">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-white">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-slate-700">Remember me</label>
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-right">
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                        Login
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center gap-4">
                    <div class="flex-1 h-px bg-slate-300"></div>
                    <span class="text-slate-500 text-sm">or</span>
                    <div class="flex-1 h-px bg-slate-300"></div>
                </div>

                <!-- Register Link -->
                <p class="text-center text-slate-700">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-colors">
                        Register here
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
