<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <a href="/">Retour au dashboard</a>

    <div class="flex flex-col items-center">
        <h1 class="text-xl">Voici les dernières transactions</h1>
        <div class="w-2/3 flex justify-center">
            <div class="overflow-x-auto rounded-lg shadow-lg m-8 w-full">
                <table class="table-auto border-collapse w-full text-left text-sm bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-800 border-b">
                        <th class="p-4 font-medium">ID</th>
                        <th class="p-4 font-medium">Label</th>
                        <th class="p-4 font-medium">Amount</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Account</th>
                        <th class="p-4 font-medium">Category</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 text-gray-700">{{ $transaction->id }}</td>
                            <td class="p-4 text-gray-700">{{ $transaction->label }}</td>
                            <td class="p-4 text-gray-700">{{ $transaction->amount }}</td>
                            <td class="p-4 text-gray-700"><div class="{{ $transaction->status == 'debit' ? "text-red-500" : "text-green-500" }}">{{ $transaction->status }}</div></td>
                            <td class="p-4 text-gray-700">{{ $transaction->account->title }}</td>
                            <td class="p-4 text-gray-700">{{ $transaction->category->title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="m-8 w-full">
                <form method="POST" action="/transaction/store" class="flex flex-col ">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="mt-2">
                        <label for="label" class="block text-sm/6 font-medium text-gray-900">Entrez le label : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="label" id="label" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="amount" class="block text-sm/6 font-medium text-gray-900">Entrez le montant de la transaction : </label>
                        <div class="mt-2">
                            <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <div class="shrink-0 select-none text-base text-gray-500 sm:text-sm/6">€</div>
                                <input type="text" name="amount" id="amount" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" placeholder="0.00">
                                <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                    <div class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pl-3 pr-2.5 text-base text-gray-500 placeholder:text-gray-400">
                                        EUR
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="status" class="block text-sm/6 font-medium text-gray-900">Choisissez le status :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="status" id="status" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <option value="debit">Débit</option>
                                <option value="credit">Crédit</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="category" class="block text-sm/6 font-medium text-gray-900">Choisissez une categorie :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="category" id="category" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="account" class="block text-sm/6 font-medium text-gray-900">Choisissez un compte :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="account" id="account" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>


