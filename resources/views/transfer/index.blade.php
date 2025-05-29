<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ __("Create a transation between your accounts") }}</x-slot:title>

    <div x-data="{
         fromAccount: '',
         toAccount: '',
         formatCurrency(amount) {
            return new Intl.NumberFormat('fr-FR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(amount);
        }
     }">
        <section>
            <div class="flex flex-col gap-y-10">
                <!-- FROM account -->
                <div class="flex flex-wrap justify-center gap-10">
                    <template x-for="account in {{ json_encode($accounts) }}">
                        <div
                            @click="fromAccount = fromAccount === account.id ? '' : account.id"
                            :class="{
                            'opacity-50 pointer-events-none': toAccount === account.id,
                            'ring ring-primary ring-offset-4 ring-offset-gray-100': fromAccount === account.id
                        }"
                            class="rounded-lg basis-auto h-24 w-60 cursor-pointer transition duration-300 bg-white"
                        >
                            <div class="flex justify-between items-center border-b px-2 py-1 rounded-t-lg bg-primary">
                                <h1 x-text="account.title.charAt(0).toUpperCase() + account.title.slice(1)"></h1>
                            </div>
                            <div class="px-4 py-2 flex flex-col justify-center">
                                <p class="text-2xl font-bold">
                                    € <span x-text="formatCurrency(account.balance)"></span>
                                </p>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="text-center">
                    <i class="fa-solid fa-2xl text-primary-dark fa-circle-arrow-down"></i>
                </div>

                <!-- TO account -->
                <div class="flex flex-wrap justify-center gap-10">
                    <template x-for="account in {{ json_encode($accounts) }}">
                        <div
                            @click="toAccount = toAccount === account.id ? '' : account.id"
                            :class="{
                            'opacity-50 pointer-events-none': fromAccount === account.id,
                            'ring ring-primary ring-offset-4 ring-offset-gray-100': toAccount === account.id
                        }"
                            class="rounded-lg basis-auto h-24 w-60 cursor-pointer transition duration-300 bg-white"
                        >
                            <div class="flex justify-between items-center border-b px-2 py-1 rounded-t-lg bg-primary">
                                <h1 x-text="account.title.charAt(0).toUpperCase() + account.title.slice(1)"></h1>
                            </div>
                            <div class="px-4 py-2 flex flex-col justify-center">
                                <p class="text-2xl font-bold">
                                    € <span x-text="formatCurrency(account.balance)"></span>
                                </p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <section class="mt-20 border-2 border-primary rounded-lg p-4">
            <form action="{{ route('transfer.create') }}" method="POST" class="flex flex-wrap gap-4 items-stretch">
                @csrf

                <div class="flex flex-col sm:flex-row flex-grow min-w-0">

                    <input
                        type="date"
                        value="{{ old('date', session('last_transaction_date', now()->format('Y-m-d'))) }}"
                        name="date" id="date"
                        class="pl-4 p-2 text-sm bg-primary-light outline-none rounded-l-lg flex-shrink-0 sm:max-w-[10rem]"
                        required
                    >

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
                        <input type="number" min="0" step="0.01" value="" placeholder="0.00" name="amount" id="amount"
                               class="p-2 w-24 text-sm outline-none bg-primary-light text-end" required>
                        <div class="p-2 bg-primary-light rounded-r-lg">
                            <i class="fa-solid fa-euro-sign text-primary-dark"></i>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="from_account_id" x-model="fromAccount">
                <input type="hidden" name="to_account_id" x-model="toAccount">

                <button type="submit"
                        class="min-w-32 px-4 py-2 bg-primary border border-transparent rounded-lg text-base tracking-widest hover:bg-primary-dark focus:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    Create
                </button>
            </form>
        </section>
    </div>

</x-app-layout>
