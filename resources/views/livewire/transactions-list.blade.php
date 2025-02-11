<div class="flex flex-grow flex-col justify-between items-center">
    <div style="max-height: 800px" class="flex flex-col space-y-4 justify-center items-center overflow-y-auto px-4">
        @forelse($transactions as $transaction)
            <div class="flex items-center">
                <div class="w-6 text-center">
                    @if($transaction->status === 'credit')
                        <i class="fa-solid fa-plus text-green-500"></i>
                    @endif
                </div>

                <div class="mx-4 inline-flex flex-grow">
                    <input type="date" disabled value="{{ $transaction->date }}" name="date" id="date" class="pl-4 p-2 text-sm min-w-56 bg-gray-200 outline-none rounded-l-lg" required>
                    <div class="border border-primary mx-1"></div>
                    <input type="text" disabled value="{{ $transaction->label }}" name="label" id="label" placeholder="Label" class="p-2 text-sm bg-gray-200 outline-none flex-grow" required>
                    <div class="border border-primary mx-1"></div>
                    <input type="text" disabled value="{{ $transaction->category->title ?? 'None' }}" name="label" id="label" class="p-2 text-sm bg-gray-200 outline-none flex-grow" required>
                    <div class="border border-primary mx-1"></div>
                    <input type="text" disabled value="{{ $transaction->amount }}" name="amount" id="amount" class="p-2 text-sm text-end outline-none bg-gray-200" required>
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
            </div>
        @empty
            <div>Nothing this month</div>
        @endforelse
    </div>

    <div class="flex flex-col justify-between items-center w-2/3  border shadow-2xl rounded-t-lg">
        <div class="flex justify-evenly w-full my-8">
            <div class="flex flex-col items-center">
                <p class="text-xl font-bold">{{ '+ '.$totalIncome.' €' }}</p>
                <p class="text-green-400">Total Income</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="text-xl font-bold">{{ '- '.$totalOutcome.' €' }}</p>
                <p class="text-red-400">Total Outcome</p>
            </div>
            <div class="flex flex-col items-center">
                <p class="text-xl font-bold">{{ $account->balance.' €' }}</p>
                <p class="text-blue-300">Money Left</p>
            </div>
        </div>

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

