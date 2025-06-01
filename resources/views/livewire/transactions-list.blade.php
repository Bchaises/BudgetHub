<div class="flex flex-grow flex-col justify-between items-center">
    <div style="height: 27rem" class="flex flex-col space-y-4 items-center overflow-y-auto px-4">
        @forelse($transactions as $transaction)
            <div class="flex items-center group" x-data="{ edit: false }" >
                <form method="POST" action="{{ route('transaction.update', ['id' => $transaction->id]) }}"  class="flex items-center">
                    @csrf
                    @method('PATCH')

                    <!-- Status Icon -->
                    <div class="w-6 text-center">
                        @if($transaction->status === 'credit')
                            <i class="fa-solid fa-plus text-green-500"></i>
                        @endif
                    </div>

                    <div class="mx-4 inline-flex flex-grow">
                        <!-- Date -->
                        <input type="date" :disabled="!edit" value="{{ $transaction->date }}" name="date" id="date" class="pl-4 p-2 text-sm min-w-56 bg-gray-200 outline-none rounded-l-lg" required>
                        <div class="border border-primary mx-1"></div>

                        <!-- Label -->
                        <input type="text" :disabled="!edit" value="{{ $transaction->label }}" name="label" id="label" placeholder="Label" class="p-2 text-sm bg-gray-200 outline-none flex-grow" required>
                        <div class="border border-primary mx-1"></div>

                        <!-- Category Selector -->
                        <div x-data="{ open: false, selected: '', iconSelected: '', labelSelected: '' }"
                             x-init="
                                selected = '{{ $transaction->category->id ?? '' }}';
                                iconSelected = '{{ $transaction->category?->icon ?? 'fa-ban' }}';
                                labelSelected = '{{ $transaction->category->title ?? 'None' }}';
                             "
                             class="relative w-40">
                            <button :disabled="!edit" type="button" @click="open = !open" @class(['w-full py-2 px-3 text-left bg-gray-200 focus:outline-none transition ease-in-out duration-150 flex items-center'])>
                                <i class="fa-solid" :class="iconSelected"></i>
                                <span class="ml-2" x-text="labelSelected"></span>
                                <i x-show="edit" class="fa-solid fa-chevron-down w-5 h-5 ml-auto"></i>
                            </button>

                            <input :disabled="!edit" type="hidden" name="category_id" id="" x-model="selected">

                            <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
                                <ul class="py-1">
                                    @foreach ($categories as $value => $data)
                                        <li @click="selected = '{{ $value }}'; open = false; iconSelected = '{{ $data['icon'] }}'; labelSelected = '{{ $data['label'] }}'" class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex items-center">
                                            <span class="mr-2"><i class="fa-solid {{ $data['icon'] }}"></i></span>
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
                        <input type="text" :disabled="!edit" value="{{ number_format((float) $transaction->amount,2, '.', '') }}" name="amount" id="amount" class="p-2 text-sm text-end outline-none bg-gray-200" required>

                        <!-- Account -->
                        <input hidden value="{{ $account->id }}" name="account_id" id="account_id">

                        <!-- Status -->
                        <input hidden value="{{ $transaction->status }}" name="status" id="status">

                        <div class="pr-4 p-2 bg-gray-200 rounded-r-lg">
                            <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                        </div>
                    </div>

                    <input name="account_id" id="account_id" value="{{ $account->id }}" hidden>
                    <input name="target_account_id" id="target_account_id" value="" hidden>

                    <div class="w-6 text-center">
                        @if($transaction->status === 'debit')
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
                    <form method="POST" action="{{ route('transaction.destroy', ['id' => $transaction->id]) }}">
                        @csrf
                        @method('delete')
                        <button x-show="edit" type="submit">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div>Nothing this month</div>
        @endforelse
    </div>

    <!-- Summary Section -->
    <div class="absolute bottom-0 flex flex-col justify-between items-center 2xl:w-1/2 xl:w-4/5 w-full border shadow-2xl rounded-t-lg">
        <div class="flex justify-evenly w-full my-8">
            <div class="flex flex-col items-center">
                <p class="text-xl font-bold">{{ '+ '.number_format((float) $totalIncome, 2, ',', ' ').' €' }}</p>
                <p class="text-green-400">Total Income</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="text-xl font-bold">{{ '- '.number_format((float) $totalOutcome, 2, ',', ' ').' €' }}</p>
                <p class="text-red-400">Total Outcome</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="text-xl font-bold">{{ number_format((float) $account->balance, 2, ',', ' ').' €' }}</p>
                <p class="text-blue-300">Money Left</p>
            </div>
        </div>

        <!-- Month Selector -->
        <div class="mb-8 p-2 flex bg-gray-300 rounded-lg">
            <button wire:click="previousMonth()" class="mr-4 ml-2">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="w-40 text-center">
                <span class="text-lg">{{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}</span>
            </div>
            <button wire:click="nextMonth()" class="ml-4 mr-2">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

