<x-layout>

    <div class="m-4">
        <a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('transaction.index') }}">/Transactions</a>
    </div>

    <div class="flex flex-col items-center justify-center">
        <h1 class="text-xl">Vous êtes sur la transaction {{ $transaction->label }}</h1>
        <div class="w-1/2">
            <div class="m-8">
                <form method="POST" action="{{ route('transaction.update', ['id' => $transaction->id ]) }}" class="flex flex-col ">
                    @csrf <!-- {{ csrf_field() }} -->
                    @method('PATCH')
                    <div class="mt-2">
                        <label for="label" class="block text-sm/6 font-medium text-gray-900">Modifiez le label de la transaction : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="label" id="label" value="{{ $transaction->label }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="amount" class="block text-sm/6 font-medium text-gray-900">Modifiez le montant de la transaction : </label>
                        <div class="mt-2">
                            <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <div class="shrink-0 select-none text-base text-gray-500 sm:text-sm/6">€</div>
                                <input type="text" name="amount" id="amount" value="{{ $transaction->amount }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                    <div class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pl-3 pr-2.5 text-base text-gray-500 placeholder:text-gray-400">
                                        EUR
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="status" class="block text-sm/6 font-medium text-gray-900">Modifiez le status :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="status" id="status" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <option
                                    @if($transaction->status === 'debit')
                                        selected
                                    @endif
                                    value="debit">
                                    Débit
                                </option>
                                <option
                                    @if($transaction->status === 'credit')
                                        selected
                                    @endif
                                    value="credit">
                                    Crédit
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="category" class="block text-sm/6 font-medium text-gray-900">Modifiez la categorie :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="category" id="category" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                @if(isset($transaction->category))
                                    <option value="{{ $transaction->category->id }}">{{ $transaction->category->title }}</option>
                                @else
                                    <option value="">None</option>
                                @endif

                                @foreach($categories as $category)
                                    @if(!isset($transaction->category) || $category->id !== $transaction->category->id)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endif
                                @endforeach

                                @if(!isset($stransaction->category))
                                    <option value="">None</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="account" class="block text-sm/6 font-medium text-gray-900">Modifiez le compte :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="account" id="account" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <option value="{{ $transaction->account->id }}">{{ $transaction->account->title }}</option>
                                @foreach($accounts as $account)
                                    @if($account->id !== $transaction->account->id)
                                        <option value="{{ $account->id }}">{{ $account->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <x-datepicker value="{{ $transaction->date }}"/>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

