<x-guest-layout>

    <x-slot:title>{{ __('Verify your email address') }}</x-slot:title>
    <x-slot:icon>fa-envelope</x-slot:icon>
    <x-slot:buttonText>{{ __('Back to log in') }}</x-slot:buttonText>
    <x-slot:buttonRoute>{{ route('login') }}</x-slot:buttonRoute>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-12 flex items-center justify-between space-x-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf

            <x-primary-button class="w-full justify-center">
                {{ __('Resend E-mail') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf

            <x-secondary-button class="w-full justify-center">
                {{ __('Log Out') }}
            </x-secondary-button>
        </form>
    </div>
</x-guest-layout>
