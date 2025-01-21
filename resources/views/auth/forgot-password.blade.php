<x-guest-layout>

    <x-slot:title>{{ __('Forgot password?') }}</x-slot:title>
    <x-slot:icon>fa-lock</x-slot:icon>
    <x-slot:buttonText>{{ __('Back to log in') }}</x-slot:buttonText>
    <x-slot:buttonRoute>{{ route('login') }}</x-slot:buttonRoute>

    <div class="mb-4 p-1 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="mt-10">
            <x-primary-button class="w-full justify-center">
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
