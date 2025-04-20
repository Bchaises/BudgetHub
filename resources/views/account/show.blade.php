<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ $currentAccount ? "Here is your account \"$currentAccount->title\"" : "No accounts to show" }}</x-slot:title>

    <!-- Accounts navigation -->
    <section>
        <div class="flex justify-between items-center">
            <div class="inline-flex justify-start flex-grow-0 items-center rounded-lg bg-gray-200 -space-x-3">
                @foreach($accounts as $account)
                    <a href="{{ route('account.show', ['id' => $account->id]) }}" style="position: relative; z-index: {{ $loop->remaining * 10 }};" >
                        <div class="border border-primary rounded-lg w-60 pl-5 pr-4 py-1 {{ $account->id === $currentAccount->id ? 'bg-primary' : 'bg-gray-200' }}">
                            <div class="flex justify-between items-center">
                                {{ $account->title }}
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($currentAccount)
                <div class="flex space-x-2">
                    <a href="{{ route('recurring.show', ['id' => $currentAccount->id])}}"><i class="fa-solid fa-clock"></i></a>
                    <a href="{{ route('account.edit', ['id' => $currentAccount->id]) }}"><i class="fa-solid fa-gear"></i></a>
                </div>
            @endif
        </div>
    </section>

    @if($currentAccount)
        <section class="mt-8 border-2 border-primary rounded-lg p-4">
            <form action="{{ route('transaction.store') }}" method="POST" class="flex flex-wrap gap-4 items-stretch">
                @csrf

                <x-select-input
                    name="status"
                    :options="['debit' => [ 'icon' => 'fa-solid fa-arrow-up-from-bracket', 'label' => 'Expense'], 'credit' => [ 'icon' => 'fa-solid fa-arrow-right-to-bracket fa-rotate-90', 'label' => 'Income']]"
                    selected="debit"
                    iconSelected="fa-solid fa-arrow-up-from-bracket"
                    labelSelected="Expense"
                    buttonClass="focus:ring-2 !focus:ring-0 focus:ring-primary focus:ring-offset-2"
                />

                <div class="flex flex-col sm:flex-row flex-grow min-w-0">

                    <input type="date" value="{{ date('Y-m-d') }}" name="date" id="date"
                           class="pl-4 p-2 text-sm bg-primary-light outline-none rounded-l-lg flex-shrink-0 sm:max-w-[10rem]" required>

                    <div class="border border-primary mx-1"></div>

                    <input type="text" value="" name="label" id="label" placeholder="Label"
                           class="p-2 text-sm bg-primary-light outline-none flex-grow min-w-0" required>

                    <div class="border border-primary mx-1"></div>

                    <x-select-input
                        name="category_id"
                        :options="$categories"
                        labelSelected="Category"
                        containerClass="min-w-56 h-full flex-grow"
                        buttonClass="rounded-none"
                    />

                    <div class="border border-primary mx-1"></div>

                    <div class="flex items-stretch">
                        <input type="text" value="" placeholder="0.00" name="amount" id="amount"
                               class="p-2 w-24 text-sm outline-none bg-primary-light text-end" required>
                        <div class="p-2 bg-primary-light rounded-r-lg">
                            <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                        </div>
                    </div>
                </div>

                <input name="account_id" id="account_id" value="{{ $currentAccount->id }}" hidden>
                <input name="target_account_id" id="target_account_id" value="" hidden>

                <button type="submit"
                        class="min-w-32 px-4 py-2 bg-primary border border-transparent rounded-lg text-base tracking-widest hover:bg-primary-dark focus:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    Add
                </button>
            </form>
        </section>


        <!-- Transactions list -->
        <section class="mt-8 flex flex-col flex-grow">
            @livewire('transactions-list', ['accountId' => $currentAccount->id, 'totalIncome' => $totalIncome, 'totalOutcome' => $totalOutcome, 'categories' => $categories])
        </section>
    @else
        <section class="flex justify-center">
                <div class="rounded-lg shadow-lg mr-12 basis-auto h-full min-w-72 max-w-96">
                    <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                        <h1 class="text-xl">No Accounts</h1>
                    </div>
                    <div class="p-4">
                        <p class="mb-4">You have to create an Account before accessing this page</p>
                        <x-primary-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'account-creation')"
                        >Create Account</x-primary-button>
                    </div>
                </div>
        </section>

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
    @endif

</x-app-layout>

