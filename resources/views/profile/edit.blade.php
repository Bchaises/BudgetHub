<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ __("Here, your profile") }}</x-slot:title>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="mb-6">
        <div class="grid lg:grid-cols-12 gap-6">

            <div class="lg:col-span-5">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="lg:col-span-7">
                @include('profile.partials.update-password-form')
            </div>

            <div class="lg:col-span-7">
                @include('profile.partials.update-email-form')
            </div>

            <div class="lg:col-span-5">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
