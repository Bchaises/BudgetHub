<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-default antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <header class="w-full p-8 text-2xl flex justify-between fixed top-0 left-0">
                <p>Hi !</p>
                <p>{{ date('l M j Y') }}</p>
            </header>
            <div class="w-full max-w-xl shadow-xl overflow-hidden rounded-lg">
                <div class="p-4 bg-primary flex items-center justify-between">
                    <h1 class="text-xl text-police flex-1 text-center">{{ $title ?? __('Default title') }}</h1>
                    <i class="{{ $icon ?? 'fa-user' }} fa-solid fa-lg"></i>
                </div>
                <div class="px-16 py-12 flex flex-col bg-white" style="min-height: 30em">
                    {{ $slot }}
                </div>
            </div>
            <div class="mt-12">
                <x-secondary-button onclick="location.href='{{ $buttonRoute ?? route('login') }}'" class="text-xs px-4 !text-gray-500">
                    {{ $buttonText ?? __('Default text') }}
                </x-secondary-button>
            </div>
        </div>
    </body>
</html>
