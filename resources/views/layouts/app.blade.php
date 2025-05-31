@props(['notifications' => []])

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

                <!-- Display messages -->
                <div class="fixed top-24 right-4 z-50 space-y-2">
                    <!-- Error messages -->
                    @if ($errors->any())
                        @foreach ($errors->all() as $index => $error)
                            @php
                                $delay = $index * 200;
                            @endphp

                            <div
                                x-data="{ show: false }"
                                x-init="
                                setTimeout(() => {
                                    show = true;
                                    setTimeout(() => show = false, 5000);
                                }, {{ $delay }});
                            "
                                x-show="show"
                                x-transition:enter="transition duration-300 ease-out"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition duration-500 ease-in"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 translate-x-4"
                                class="min-w-80 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow"
                                role="alert"
                            >
                                <svg class="shrink-0 inline w-4 h-4 me-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <div>{{ $error }}</div>
                            </div>
                        @endforeach
                    @endif

                    <!-- success message -->
                    @if (session('success'))
                        <div
                            x-data="{ show: true }"
                            x-init="setTimeout(() => show = false, 5000)"
                            x-show="show"
                            x-transition:enter="transition duration-300 ease-out"
                            x-transition:enter-start="opacity-0 translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition duration-500 ease-in"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-4"
                            class="min-w-80 flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert"
                        >
                            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Header -->
                <header class="my-8 mx-11 flex justify-between items-center">
                    <h1 class="text-2xl">{{ $title }}</h1>
                    <div class="flex flex-row gap-6 items-center">
                        <div class="flex flex-row gap-2">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ openNotifications: false }">
                                <button @click="openNotifications = !openNotifications" type="button" class="relative inline-flex justify-center items-center size-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <i class="fa-solid fa-bell fa-xl text-primary-dark"></i>
                                    @if(count($notifications) > 0)
                                        <span class="absolute top-0 end-0 inline-flex justify-center items-center w-5 h-5 py-0.5 px-1.5 rounded-full text-xs font-medium transform -translate-y-1/2 translate-x-1/2 bg-red-500 text-white">{{ count($notifications) }}</span>
                                    @endif
                                </button>

                                <div x-show="openNotifications" @click.away="openNotifications = false" class="absolute overflow-visible right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg p-4 text-left z-50">
                                    @forelse($notifications as $key => $notification)
                                        @if(($key+1) % 2 == 0)
                                            <div class="w-full h-px bg-gray-400 my-4"></div>
                                        @endif
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-700 mb-1">
                                                <span class="font-bold">{{ $notification->sender->name }}</span> vous invite à rejoindre le compte <span class="font-bold">{{ $notification->account->title }}</span>
                                            </p>
                                            <div class="flex gap-2">
                                                <a href="{{ route('invitation.respondWithoutToken', ['id' => $notification->id]) . '?status=accepted' }}" class="text-green-600 hover:underline text-sm">Accepter</a>
                                                <a href="{{ route('invitation.respondWithoutToken', ['id' => $notification->id]) . '?status=rejected' }}" class="text-red-600 hover:underline text-sm">Refuser</a>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-600">No notifications</p>
                                    @endforelse
                                </div>
                            </div>
                            <!-- Profil Dropdown -->
                            <div class="relative" x-data="{ openProfile: false }">
                                <button @click="openProfile = !openProfile" type="button" class="relative inline-flex justify-center items-center size-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <i class="fa-solid fa-user fa-xl text-primary-dark"></i>
                                </button>

                                <div x-show="openProfile" @click.away="openProfile = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg text-left z-50">
                                    <div class="flex flex-col">
                                        <a href="{{ route('profile.edit') }}" class="w-full rounded-t-lg text-left text-sm text-gray-700 p-3 hover:bg-gray-50">
                                            Profile
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left text-sm text-danger rounded-b-lg p-3 hover:bg-gray-50">Log Out</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>{{ date('l M j Y') }}</p>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="2xl:mx-72 xl:mx-40 mx-16 flex flex-col flex-grow">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
