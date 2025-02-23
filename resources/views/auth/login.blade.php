<x-guest-layout>

    <x-slot:title>{{ __('Log In') }}</x-slot:title>
    <x-slot:icon>fa-user</x-slot:icon>
    <x-slot:buttonText>{{ __('Never registered ? Please sign in') }}</x-slot:buttonText>
    <x-slot:buttonRoute>{{ route('register') }}</x-slot:buttonRoute>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="flex flex-col flex-1 justify-between">
        @csrf

        <div>
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('E-mail')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <x-checkbox id="remember_me" name="remember" :value="false" :label="__('Remember me')" :required="false"/>
        </div>


        <!-- Submit and Forgot Password -->
        <div class="flex items-center justify-center mt-12 w-full">
            <x-primary-button class="mr-2 flex-1 justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            <x-secondary-button onclick="location.href='{{ route('password.request') }}'" type="button" class="ml-2 flex-1 justify-center">
                {{ __('Forgot password ?') }}
            </x-secondary-button>
        </div>
    </form>
</x-guest-layout>
