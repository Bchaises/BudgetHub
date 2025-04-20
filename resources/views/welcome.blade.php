<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BudgetHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#FF2D20]/5 via-white to-white dark:from-black dark:via-zinc-900 dark:to-zinc-900 min-h-screen flex items-center justify-center text-black dark:text-white">
<div class="w-full max-w-3xl mx-auto text-center px-6 py-16">
    <div class="mb-8">
        <h1 class="text-5xl font-bold text-primary mb-4">Welcome to BudgetHub</h1>
        <p class="text-lg text-black/70 dark:text-white/70">Personal finance, made simple, elegant and efficient.</p>
    </div>

    <div class="flex flex-col sm:flex-row justify-center gap-6 mt-10">
        @auth
            <a href="{{ url('/dashboard') }}" class="px-6 py-3 rounded-lg bg-primary text-gray-500 hover:bg-primary-dark transition text-lg font-semibold shadow">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 transition text-lg font-semibold text-black dark:text-white">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-6 py-3 rounded-lg bg-primary text-gray-500 hover:bg-primary-dark transition text-lg font-semibold shadow">Log in</a>
            <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-primary text-gray-500 hover:bg-primary-dark transition text-lg font-semibold shadow">Sign up</a>
        @endauth
    </div>

    <div class="mt-16 text-sm text-zinc-500 dark:text-zinc-400">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </div>
</div>
</body>
</html>
