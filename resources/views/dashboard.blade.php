<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ "Hi, Welcome back ".strtolower($user->name)." 👋!" }}</x-slot:title>

    <div class="w-full mt-8">
        <div class="flex flex-wrap">
            @foreach($accounts as $account)
                <a href="{{ route('account.show', ['id' => $account->id]) }}">
                    <div class="rounded-lg shadow-lg mr-6 basis-auto h-full w-72 cursor-pointer hover:shadow-xl transition duration-300">
                        <div class="flex justify-between items-center border-b px-2 py-1 rounded-t-lg bg-primary">
                            <h1 class="">{{ ucfirst($account->title) }}</h1>
                            <i class="fa-solid fa-euro-sign"></i>
                        </div>
                        <div class="px-4 py-2 flex flex-col justify-center">
                            <p class="text-2xl font-bold"><span>€ </span>{{ $account->balance }}</p>
                            <p class="text-sm">{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            @if($accountsStat[$account->id] !== 0)
                                <div class="flex text-xs space-x-2 items-center {{ $accountsStat[$account->id] < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    @if( $accountsStat[$account->id] < 0)
                                        <i class="fa-solid fa-lg fa-arrow-trend-down"></i> <p>{{ $accountsStat[$account->id]." €" }}</p>
                                    @elseif( $accountsStat[$account->id] > 0)
                                        <i class="fa-solid fa-lg fa-arrow-trend-up"></i> <p>{{ "+".$accountsStat[$account->id]." €" }}</p>
                                    @endif
                                    <p>from last month</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
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

                            <x-input-error :messages="$errors->accountCreation->get('title')" class="mt-2" />

                            <x-text-input
                                id="description"
                                name="description"
                                type="text"
                                class="mt-4 block w-full"
                                placeholder="{{ __('Description') }}"
                            />

                            <x-input-error :messages="$errors->accountCreation->get('description')" class="mt-2" />

                            <x-money-input
                                id="balance"
                                name="balance"
                                type="number"
                                class="mt-4 block w-full"
                                placeholder="0.00"
                                required
                            />

                            <x-input-error :messages="$errors->accountCreation->get('balance')" class="mt-2" />
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

        <div class="flex mt-16">

            <div class="basis-2/3 mr-12 shadow-lg">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly expenses</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>

            </div>

            <div class="basis-1/3 shadow-lg">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly expenses by categories</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>
                <div class="flex flex-col space-y-2 p-4">
                    @foreach($expensesByCategories as $key => $expense)
                        <div class="flex justify-between">
                            <div>{{ $key }}</div>
                            <div>{{ $expense }} €</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
