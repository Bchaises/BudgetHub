<x-app-layout>

    <x-slot:title>{{ "Here is your recurring transactions of \"$account->title\"" }}</x-slot:title>

    <!-- Accounts navigation -->
    <section>
        <a href="{{ route('account.show', ['id' => $account->id]) }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
    </section>

    <!-- Transaction form -->
    <section class="mt-8">
        <div class="border-2 border-primary rounded-lg p-4 flex">
            <form action="{{ route('transaction.store') }}" method="POST" class="flex flex-grow items-center">
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

                    <input type="text" value="" placeholder="0.00" name="amount" id="amount" class="p-2 text-sm outline-none bg-primary-light text-end" required>
                    <div class="pr-4 p-2 bg-primary-light rounded-r-lg">
                        <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                    </div>
                </div>

                <input name="account_id" id="account_id" value="{{ $account->id }}" hidden>
                <input name="target_account_id" id="target_account_id" value="" hidden>

                <button type="submit" class="ml-4 min-w-40 inline-flex items-center justify-center px-2 py-2 bg-primary border border-transparent rounded-lg text-base tracking-widest hover:bg-primary-dark focus:bg-primary active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    Add
                </button>
            </form>
        </div>
    </section>

    <!-- Transactions list -->
    <section class="mt-8 flex flex-col flex-grow">
    </section>
</x-app-layout>

