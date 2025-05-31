<section class="h-full">
    <div class="bg-white shadow sm:rounded-lg h-full">
        <header>
            <div class="p-4 bg-primary flex items-center justify-between overflow-hidden">
                <i class="fa-solid fa-chart-simple"></i>
                <h1 class="text-xl text-police flex-1 text-center">{{ __('Update your budgets') }}</h1>
            </div>
        </header>
        <div class="p-4 sm:p-8 flex flex-col gap-y-3">
            <div class="overflow-visible border-primary border-2 rounded-lg p-2">
                <form method="POST" action="{{ route('budget.store') }}" class="flex flex-row gap-2 justify-between">
                    @csrf
                    @method("post")
                    <x-select-input
                        name="category_id"
                        :options="$categories"
                        labelSelected="Category"
                        listHeight="max-h-40"
                    />

                    <div class="flex items-stretch w-full">
                        <input type="number" min="0" step="0.01" value="" placeholder="0.00" name="amount" id="amount"
                               class="p-2 text-sm w-full outline-none bg-primary-light rounded-l-lg text-end" required>
                        <div class="p-2 bg-primary-light rounded-r-lg">
                            <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                        </div>
                    </div>

                    <input type="hidden" value="{{ $account->id }}" name="account_id">

                    <button type="submit"
                            class="min-w-32 px-4 py-2 bg-primary border border-transparent rounded-lg text-base tracking-widest hover:bg-primary-dark focus:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                        Add
                    </button>
                </form>
            </div>

            <div class="flex flex-wrap gap-3">
                @foreach($budgets as $budget)
                    <div class="flex flex-row gap-2 p-2 bg-gray-200 rounded-xl text-xs">
                        <p>{{ $budget->category->title }}</p>
                        <p>{{ number_format($budget->amount, 2, ',') }}€</p>
                        <form method="POST" action="{{ route('budget.destroy', ['id' => $budget->id]) }}">
                            @csrf
                            @method('delete')
                            <button type="submit"><i class="fa-solid fa-lg fa-xmark text-gray-600"></i></button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
