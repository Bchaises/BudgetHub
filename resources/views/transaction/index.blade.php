<x-app-layout>

    <x-slot:title>{{ "Here, your transactions" }}</x-slot:title>

    <div>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>

    <div class="flex flex-col items-center">
        <div class="w-2/3 flex justify-center">
            <div class="overflow-x-auto rounded-lg shadow-lg m-8 w-full basis-2/3">
                <table class="table-auto border-collapse w-full text-left text-sm bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-800 border-b">
                        <th class="p-4 font-medium">ID</th>
                        <th class="p-4 font-medium">Label</th>
                        <th class="p-4 font-medium">Amount</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Account</th>
                        <th class="p-4 font-medium">Category</th>
                        <th class="p-4 font-medium">Date</th>
                        <th class="p-4 font-medium">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 text-gray-700">{{ $transaction->id }}</td>
                            <td class="p-4 text-gray-700">{{ $transaction->label }}</td>
                            <td class="p-4 text-gray-700">{{ $transaction->amount }}€</td>
                            <td class="p-4 text-gray-700"><div class="{{ $transaction->status == 'debit' ? "text-red-500" : "text-green-500" }}">{{ $transaction->status }}</div></td>
                            <td class="p-4 text-gray-700">{{ $transaction->account->title }}</td>
                            <td class="p-4 text-gray-700">{{ $transaction->category->title ?? 'None' }}</td>
                            <td class="p-4 text-gray-700">{{ date('d/m/Y', strtotime($transaction->date)) }}</td>
                            <td class="p-4 text-gray-700 flex items-center">
                                <form method="POST" action="{{ route('transaction.destroy', ['id' => $transaction->id]) }}" class="m-0">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" fill="gray" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                    </button>
                                </form>

                                <a href="{{ route('transaction.show', ['id' => $transaction->id]) }}" class="ml-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="gray" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="m-8 w-full basis-1/3">
                <form method="POST" action="{{ route('transaction.store') }}" class="flex flex-col ">
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
                        <label for="category_id" class="block text-sm/6 font-medium text-gray-900">Choisissez une categorie :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="category_id" id="category_id" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <option value="" >None</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="account_id" class="block text-sm/6 font-medium text-gray-900">Choisissez un compte :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="account_id" id="account_id" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="target_account_id" class="block text-sm/6 font-medium text-gray-900">Choisissez un compte à cibler :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="target_account_id" id="target_account_id" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <option value="">None</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center">
                        <input type="checkbox" id="is_recurring" name="is_recurring" class="mr-2">
                        <label for="is_recurring" class="text-sm font-medium text-gray-900">Créer une transaction récurrente</label>
                    </div>

                    <div id="recurring_fields" class="mt-2 hidden">
                        <div class="mt-2 flex flex-col">
                            <label for="frequency" class="block text-sm/6 font-medium text-gray-900">Choisissez la fréquence :</label>
                            <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <select name="frequency" id="frequency" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label for="start_date" class="block text-sm/6 font-medium text-gray-900">Choisissez une date de début : </label>
                            <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <input type="date" value="{{ date('Y-m-d') }}" name="start_date" id="start_date" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label for="end_date" class="block text-sm/6 font-medium text-gray-900">Choisissez une date de fin : </label>
                            <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <input type="date" name="end_date" id="end_date" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                            </div>
                        </div>
                    </div>

                    <div id="single_date" class="mt-2">
                        <div class="mt-2">
                            <label for="date" class="block text-sm/6 font-medium text-gray-900">Choisissez une date : </label>
                            <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <input type="date" value="{{ date('Y-m-d') }}" name="date" id="date" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const checkbox = document.getElementById('is_recurring');
                            const recurringFields = document.getElementById('recurring_fields');
                            const singleDate = document.getElementById('single_date');

                            checkbox.addEventListener('change', function () {
                                if (this.checked) {
                                    recurringFields.classList.remove('hidden');
                                    singleDate.classList.add('hidden');
                                } else {
                                    recurringFields.classList.add('hidden');
                                    singleDate.classList.remove('hidden');
                                }
                            });
                        });
                    </script>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                    </div>

                    @isset($errors)
                        {{ $errors }}
                    @endisset
                </form>
            </div>
        </div>

        <div class="w-2/3">
            <a href="{{ route('category.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg ml-8">
                Modifier les catégories
            </a>
        </div>
    </div>
</x-app-layout>


