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
        <div class="flex min-h-screen bg-gray-100 text-police">
            <!-- Navigation Bar -->
            @include('layouts.navigation')

            <div class="flex flex-col flex-1">
                <!-- Header -->
                <header class="my-8 mx-11 flex justify-between items-end">
                    <h1 class="text-2xl">{{ $title }}</h1>
                    <p>{{ date('l M j Y') }}</p>
                </header>

                <!-- Page Content -->
                <main class="2xl:mx-72 xl:mx-40 mx-16 flex flex-col flex-grow">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
