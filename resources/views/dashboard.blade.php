<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ "Hi, Welcome back ".strtolower($user->name)." 👋!" }}</x-slot:title>

    <div class="mb-8">
        <div class="flex gap-6 flex-wrap">
            @foreach($accounts as $account)
                <div class="relative">
                    <a
                        href="{{ route('account.show', ['id' => $account->id]) }}"
                        class="block rounded-lg shadow-lg basis-auto h-full w-72 cursor-pointer hover:shadow-xl transition duration-300 bg-white"
                    >
                        <div class="flex justify-between items-center border-b px-2 py-1 rounded-t-lg bg-primary">
                            <h1 class="">{{ ucfirst($account->title) }}</h1>
                            <i class="fa-solid fa-euro-sign"></i>
                        </div>
                        <div class="px-4 py-2 flex flex-col justify-center">
                            <p class="text-2xl font-bold">
                                <span>€ </span>{{ number_format($account->balance, 2, ',', ' ') }}
                            </p>
                            <p class="text-sm">
                                {{ strlen($account->description) > 50 ? substr($account->description, 0, 50).'...' : $account->description }}
                            </p>

                            @if($accountsStat[$account->id] !== 0)
                                <div class="flex text-xs space-x-2 items-center {{ $accountsStat[$account->id] < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    @if($accountsStat[$account->id] < 0)
                                        <i class="fa-solid fa-lg fa-arrow-trend-down"></i>
                                        <p>{{ str_replace('-', '- ', number_format((float) $accountsStat[$account->id], 2, ',', ' ')) }} €</p>
                                    @else
                                        <i class="fa-solid fa-lg fa-arrow-trend-up"></i>
                                        <p>+ {{ number_format((float) $accountsStat[$account->id], 2, ',', ' ') }} €</p>
                                    @endif
                                    <p>from last month</p>
                                </div>
                            @endif
                        </div>
                    </a>

                    {{-- Bouton de changement de compte actif, en dehors du <a> principal --}}
                    <form method="GET" action="{{ route('dashboard') }}" class="absolute bottom-1 right-1">
                        <input type="hidden" name="accountId" value="{{ $account->id }}">
                        <button
                            type="submit"
                            style="width: 30px; height: 30px;"
                            class="p-1 rounded hover:bg-gray-100 transition"
                            title="Afficher ce compte sur le dashboard"
                        >
                            <i class="fa-solid {{ $currentAccount->id === $account->id ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                        </button>
                    </form>
                </div>

            @endforeach

            <div class="flex items-center">
                <button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'account-creation')"
                    type="button"
                    class="bg-gray-200 p-2 rounded-lg w-10 h-10 cursor-pointer flex items-center justify-center"
                ><i class="fa-solid fa-plus"></i></button>

                <x-modal
                    class="absolute"
                    title="{{ __('Create a new account') }}"
                    name="account-creation" :show="$errors->accountCreation->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('account.store') }}" class="p-10">
                        @csrf
                        @method('post')

                        <p class="mt-1 text-xl text-gray-600">
                            {{ __('Complete the following fields : ') }}
                        </p>

                        <div class="mt-8">

                            <x-text-input
                                id="title"
                                name="title"
                                type="text"
                                class="mt-4 block w-full"
                                placeholder="{{ __('Title') }}"
                                required
                            />

                            <x-text-input
                                id="description"
                                name="description"
                                type="text"
                                class="mt-4 block w-full"
                                placeholder="{{ __('Description') }}"
                            />

                            <x-money-input
                                id="balance"
                                name="balance"
                                type="number"
                                min="0"
                                step="0.01"
                                class="mt-4 block w-full"
                                placeholder="0.00"
                                required
                            />
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <x-primary-button class="flex flex-1 justify-center" x-on:click="$dispatch('close')" type="button">
                                {{ __('Cancel') }}
                            </x-primary-button>

                            <x-primary-button type="submit" class="flex flex-1 justify-center">
                                {{ __('Create Account') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>

        <div class="grid lg:grid-cols-12 gap-6 mt-6">

            <div class="lg:col-span-8">
                @include('account.partials.monthly-expenses-by-categories')
            </div>

            <div class="lg:col-span-4">
                @include('account.partials.expenses-by-categories-this-month')
            </div>

            <div class="lg:col-span-4">
                @include('account.partials.budget-progress')
            </div>

            <div class="lg:col-span-8">
                @include('account.partials.monthly-credits-and-debits')
            </div>
        </div>
    </div>
</x-app-layout>
