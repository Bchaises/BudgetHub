<section>
    <div class="bg-white shadow sm:rounded-lg overflow-hidden">
        <header>
            <div class="p-4 bg-primary flex items-center justify-between overflow-hidden">
                <i class="fa-solid fa-building-columns"></i>
                <h1 class="text-xl text-police flex-1 text-center">{{ __('Change account information') }}</h1>
            </div>
        </header>
        <div class="p-4 sm:p-8">
            <form method="post" action="{{ route('account.update', ['id' => $account->id]) }}" class="flex flex-col gap-8">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $account->title }}" autofocus autocomplete="title" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ $account->description }}" autofocus autocomplete="description" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button class="lg:w-32 w-full justify-center">{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'account-updated')
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
