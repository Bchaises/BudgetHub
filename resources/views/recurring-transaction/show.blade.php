<x-app-layout>

    <x-slot:title>{{ "Here is your recurring transactions of \"$account->title\"" }}</x-slot:title>

    <!-- Accounts navigation -->
    <section>
        <a href="{{ route('account.show', ['id' => $account->id]) }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
    </section>

    <!-- Recurring Transaction form -->
    <section class="mt-8">
        <div class="border-2 border-primary rounded-lg p-4 flex">
            <form action="{{ route('recurring.store') }}" method="POST" class="flex flex-grow items-start">
                @csrf

                <x-select-input
                    name="status"
                    :options="['debit' => [ 'icon' => 'fa-solid fa-arrow-up-from-bracket', 'label' => 'Expense'], 'credit' => [ 'icon' => 'fa-solid fa-arrow-right-to-bracket fa-rotate-90', 'label' => 'Income']]"
                    selected="debit"
                    iconSelected="fa-solid fa-arrow-up-from-bracket"
                    labelSelected="Expense"
                    buttonClass="focus:ring-2 !focus:ring-0 focus:ring-primary focus:ring-offset-2"
                />

                <div class="flex flex-col flex-grow">
                    <div class="ml-4 inline-flex flex-grow">
                        <input type="date" value="{{ date('Y-m-d') }}" name="start_date" id="start_date" class="pl-4 p-2 text-sm min-w-56 bg-primary-light outline-none rounded-l-lg" required>

                        <div class="border border-primary mx-1"></div>

                        <input type="date" value="" name="end_date" id="end_date" class="pl-4 p-2 text-sm min-w-56 bg-primary-light outline-none">

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

                    <div class="ml-4 flex items-center space-x-6">
                        <x-checkbox type="radio" value="daily" :label="__('Daily')" name="frequency" id="daily"/>
                        <x-checkbox type="radio" value="weekly" :label="__('Weekly')" name="frequency" id="weekly"/>
                        <x-checkbox type="radio" value="monthly" :label="__('Monthly')" name="frequency" id="monthly"/>
                        <x-checkbox type="radio" value="yearly" :label="__('Yearly')" name="frequency" id="yearly"/>
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

    <!-- Recurring transaction list -->
    <section class="mt-8">
        <div class="flex flex-grow flex-col justify-between items-center">
            <div style="max-height: 780px;" class="flex flex-col space-y-4 items-center px-4">
                @forelse($recurringTransactions as $recurringTransaction)
                    <div class="flex items-center group" x-data="{ edit: false }" >
                        <form method="POST" action="{{ route('recurring.update', ['id' => $recurringTransaction->id]) }}"  class="flex items-center">
                            @csrf
                            @method('PATCH')

                            <!-- Status Icon -->
                            <div class="w-6 text-center">
                                @if($recurringTransaction->status === 'credit')
                                    <i class="fa-solid fa-plus text-green-500"></i>
                                @endif
                            </div>

                            <div class="mx-4 inline-flex flex-grow">
                                <!-- Start date -->
                                <input type="date" :disabled="!edit" value="{{ $recurringTransaction->start_date }}" name="start_date" id="start_date" class="pl-4 p-2 text-sm min-w-56 bg-gray-200 outline-none rounded-l-lg" required>
                                <div class="border border-primary mx-1"></div>

                                <!-- End date -->
                                <input type="date" :disabled="!edit" value="{{ $recurringTransaction->end_date }}" name="end_date" id="end_date" class="pl-4 p-2 text-sm min-w-56 bg-gray-200 outline-none">
                                <div class="border border-primary mx-1"></div>

                                <!-- Label -->
                                <input type="text" :disabled="!edit" value="{{ $recurringTransaction->label }}" name="label" id="label" placeholder="Label" class="p-2 text-sm bg-gray-200 outline-none flex-grow" required>
                                <div class="border border-primary mx-1"></div>

                                <!-- Frequency -->
                                <input type="text" :disabled="!edit" value="{{ $recurringTransaction->frequency }}" name="frequency" id="frequency" placeholder="frequency" class="p-2 text-sm bg-gray-200 outline-none flex-grow" required>
                                <div class="border border-primary mx-1"></div>

                                <!-- Category Selector -->
                                <div x-data="{ open: false, selected: '{{ $recurringTransaction->catergory->title ?? '' }}', iconSelected: '{{ $recurringTransaction->category?->icon !== null ? 'fa-solid '.$recurringTransaction->category->icon : 'fa-solid fa-xmark' }}', 'labelSelected': '{{ $transaction->category->title ?? 'None' }}' }" @class(['relative w-40'])>
                                    <button :disabled="!edit" type="button" @click="open = !open" @class(['w-full py-2 px-3 text-left bg-gray-200 focus:outline-none transition ease-in-out duration-150 flex items-center'])>
                                        <i :class="iconSelected"></i>
                                        <span class="ml-2" x-text="labelSelected"></span>
                                        <i x-show="edit" class="fa-solid fa-chevron-down w-5 h-5 ml-auto"></i>
                                    </button>

                                    <input :disabled="!edit" type="hidden" name="category_id" id="" x-model="selected">

                                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                                        <ul class="py-1">
                                            @foreach ($categories as $value => $data)
                                                <li @click="selected = '{{ $value }}'; open = false; iconSelected = '{{ $data['icon'] }}'; labelSelected = '{{ $data['label'] }}'" class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex items-center">
                                                    <span class="mr-2"><i class="{{ $data['icon'] }}"></i></span>
                                                    <span>{{ $data['label'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('alpine:init', () => {
                                        Alpine.data('selectDropdown', (selected, options) => ({
                                            open: false,
                                            selected: selected,
                                            options: options
                                        }));
                                    });
                                </script>

                                <div class="border border-primary mx-1"></div>

                                <!-- Amount -->
                                <input type="text" :disabled="!edit" value="{{ $recurringTransaction->amount }}" name="amount" id="amount" class="p-2 text-sm text-end outline-none bg-gray-200" required>

                                <!-- Account -->
                                <input hidden value="{{ $account->id }}" name="account_id" id="account_id">

                                <!-- Status -->
                                <input hidden value="{{ $recurringTransaction->status }}" name="status" id="status">

                                <div class="pr-4 p-2 bg-gray-200 rounded-r-lg">
                                    <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                                </div>
                            </div>

                            <input name="account_id" id="account_id" value="{{ $account->id }}" hidden>
                            <input name="target_account_id" id="target_account_id" value="" hidden>

                            <div class="w-6 text-center">
                                @if($recurringTransaction->status === 'debit')
                                    <i class="fa-solid fa-minus text-red-500"></i>
                                @endif
                            </div>

                            <!-- Transaction Controls -->
                            <div class="ml-4 w-10 flex gap-2">
                                <button x-show="!edit" @click="edit = true" type="button" class="hidden group-hover:block transition-opacity duration-300">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <button x-show="edit" @click="edit = false" type="button">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <button type="submit" x-show="edit">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Delete Button -->
                        <div class="w-6 ml-1 flex">
                            <form method="POST" action="{{ route('recurring.destroy', ['id' => $recurringTransaction->id]) }}">
                                @csrf
                                @method('delete')
                                <button x-show="edit" type="submit">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div>Nothing to show</div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>

