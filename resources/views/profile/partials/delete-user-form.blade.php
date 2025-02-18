<section class="h-full">
    <div class="h-full flex flex-col bg-white shadow sm:rounded-lg overflow-hidden">
        <header>
            <div class="p-4 bg-primary flex items-center justify-between overflow-hidden">
                <i class="fa-trash fa-solid fa-lg"></i>
                <h1 class="text-xl text-police flex-1 text-center">{{ __('Delete your profile') }}</h1>
            </div>
        </header>
        <div class="p-4 sm:p-8 flex h-full flex-col justify-between">
            <div class="pb-2">
                <p>{{ __('Once your profile is deleted, all of its resources and data will be  permanently deleted. Before deleting your profile, please download any  data or information that you wish to retain.') }}</p>
            </div>
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                type="button"
                class="lg:w-40 w-full justify-center"
            >{{ __('Delete Profile') }}</x-danger-button>
        </div>

        <x-modal
            class="absolute"
            title="{{ __('Are you sure you want to delete your account?') }}"
            name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-10">
                @csrf
                @method('delete')

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Once your profile is deleted, all of its resources and data will be  permanently deleted. Before deleting your profile, please download any  data or information that you wish to retain.') }}
                </p>

                <div class="mt-12">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="{{ __('Password') }}"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex space-x-4">
                    <x-primary-button class="flex flex-1 justify-center" x-on:click="$dispatch('close')" type="button">
                        {{ __('Cancel') }}
                    </x-primary-button>

                    <x-danger-button class="flex flex-1 justify-center">
                        {{ __('Delete Profile') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</section>
