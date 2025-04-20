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
                <!-- Header -->
                <header class="my-8 mx-11 flex justify-between items-center">
                    <h1 class="text-2xl">{{ $title }}</h1>
                    <div class="flex flex-row gap-6 items-center">
                        <div class="flex flex-row gap-2">
                            <!-- Profil Dropdown -->
                            <div class="relative" x-data="{ openProfile: false }">
                                <button @click="openProfile = !openProfile" type="button" class="relative inline-flex justify-center items-center size-11 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                                    <i class="fa-solid fa-user fa-xl text-primary-dark"></i>
                                </button>

                                <div x-show="openProfile" @click.away="openProfile = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg p-4 text-left z-50">
                                    <p class="text-sm text-gray-700 mb-3">Mon compte</p>
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('profile.edit') }}" class="w-full text-left text-sm text-gray-700 hover:underline">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left text-sm text-danger hover:underline">Log Out</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

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
