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
        <div class="h-screen w-screen flex bg-gray-100 text-police">
            <!-- Navigation Bar -->
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="xl:mx-72 lg:mx-32 h-screen w-screen">

                <!-- Header -->
                <header class="w-full my-8 flex justify-between items-end">
                    <h1 class="text-2xl">{{ $title }}</h1>
                    <p>{{ date('l M j Y') }}</p>
                </header>

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
