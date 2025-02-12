<x-app-layout>

    <x-slot:title>{{ "Here is your account \"$currentAccount->title\"" }}</x-slot:title>

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

            <div class="flex space-x-2">
                <a href="{{ route('recurring.show', ['id' => $currentAccount->id])}}"><i class="fa-solid fa-clock"></i></a>
                <a><i class="fa-solid fa-gear"></i></a>
            </div>
        </div>
    </section>

    <!-- Transaction form -->
    <section class="mt-8 border-2 border-primary rounded-lg p-4">
        <form action="{{ route('transaction.store') }}" method="POST" class="flex flex-grow items-center gap-4">
            @csrf

            <x-select-input
                name="status"
                :options="['debit' => [ 'icon' => 'fa-solid fa-arrow-up-from-bracket', 'label' => 'Expense'], 'credit' => [ 'icon' => 'fa-solid fa-arrow-right-to-bracket fa-rotate-90', 'label' => 'Income']]"
                selected="debit"
                iconSelected="fa-solid fa-arrow-up-from-bracket"
                labelSelected="Expense"
                buttonClass="focus:ring-2 !focus:ring-0 focus:ring-primary focus:ring-offset-2"
            />

            <div class="ml-4 inline-flex flex-grow">
                <input type="date" value="{{ date('Y-m-d') }}" name="date" id="date" class="pl-4 p-2 text-sm min-w-56 bg-primary-light outline-none rounded-l-lg" required>

                <div class="border border-primary mx-1"></div>

                <input type="text" value="" name="label" id="label" placeholder="Label" class="p-2 text-sm bg-primary-light outline-none flex-grow" required>

                <div class="border border-primary mx-1"></div>

                <x-select-input
                    name="category_id"
                    :options="$categories"
                    labelSelected="Category"
                    containerClass="w-56"
                    buttonClass="rounded-none"
                />

                <div class="border border-primary mx-1"></div>

                <input type="text" value="" placeholder="0.00" name="amount" id="amount" class="p-2 text-sm outline-none bg-primary-light text-end" required>
                <div class="pr-4 p-2 bg-primary-light rounded-r-lg">
                    <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                </div>
            </div>

            <input name="account_id" id="account_id" value="{{ $currentAccount->id }}" hidden>
            <input name="target_account_id" id="target_account_id" value="" hidden>

            <button type="submit" class="ml-4 min-w-40 inline-flex items-center justify-center px-2 py-2 bg-primary border border-transparent rounded-lg text-base tracking-widest hover:bg-primary-dark focus:bg-primary active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                Add
            </button>
        </form>
    </section>

    <!-- Transactions list -->
    <section class="mt-8 flex flex-col flex-grow">
        @livewire('transactions-list', ['accountId' => $currentAccount->id, 'totalIncome' => $totalIncome, 'totalOutcome' => $totalOutcome, 'categories' => $categories])
    </section>
</x-app-layout>

