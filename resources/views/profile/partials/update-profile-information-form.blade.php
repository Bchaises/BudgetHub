<section>
    <div class="bg-white shadow sm:rounded-lg overflow-hidden">
        <header>
            <div class="p-4 bg-primary flex items-center justify-between overflow-hidden">
                <i class="fa-user fa-solid fa-lg"></i>
                <h1 class="text-xl text-police flex-1 text-center">{{ __('Change your identity') }}</h1>
            </div>
        </header>
        <div class="p-4 sm:p-8">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update.information') }}" class="flex flex-col gap-8">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"  autofocus autocomplete="first_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"  autofocus autocomplete="last_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <div>
                    <x-input-label for="name" :value="__('Pseudo')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button class="lg:w-32 w-full justify-center">{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'profile-information-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        ><i class="fa-solid fa-check pr-2"></i>{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>
