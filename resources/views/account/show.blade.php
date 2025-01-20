<x-app-layout>

    <div class="m-4">
        <a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('account.index') }}">/Accounts</a>
    </div>

    <div class="flex flex-col items-center">
        <h1 class="text-xl">Vous êtes sur le compte {{ $account->title }}</h1>
        <div class="w-2/3">
            <div class="m-8">
                <form method="POST" action="{{ route('account.update', ['id' => $account->id]) }}" class="flex flex-col ">
                    @csrf <!-- {{ csrf_field() }} -->
                    @method('PATCH')
                    <div class="mt-2">
                        <label for="title" class="block text-sm/6 font-medium text-gray-900">Entrez le titre du compte : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="title" id="title" value="{{ $account->title }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">Entrez la description de ce compte : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="description" id="description" value="{{ $account->description }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="balance" class="block text-sm/6 font-medium text-gray-900">Entrez la balance de votre compte : </label>
                        <div class="mt-2">
                            <div class="flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <div class="shrink-0 select-none text-base text-gray-500 sm:text-sm/6">€</div>
                                <input disabled type="text" name="balance" id="balance" value="{{ $account->balance }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                    <div class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pl-3 pr-2.5 text-base text-gray-500 placeholder:text-gray-400">
                                        EUR
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                    </div>
                </form>
            </div>

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
                            <td class="p-4 text-gray-700">{{ $transaction->category->title ?? 'None' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

