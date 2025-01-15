<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <h1>Bienvenue dans votre dashboard</h1>

    <p>Ici vous retrouverez les graphiques et les statistiques de vos comptes</p>

    <div>
        <a href="{{ route('transaction.index') }}">Go to Transaction</a><br>
        <a href="{{ route('account.index') }}">Go to Account</a>
    </div>

    <div class="w-full flex justify-center">
        <div class="w-2/3">
            <div class="flex flex-wrap">
                @foreach($accounts as $account)
                    <a href="{{ route('account.show', ['id' => $account->id]) }}">
                        <div class="rounded-lg shadow-lg mx-4 basis-auto h-full min-w-72 max-w-96 cursor-pointer hover:shadow-2xl transition duration-300">
                            <div class="border-b p-3 rounded-t-lg bg-orange-200">
                                <h1>{{ ucfirst($account->title) }}</h1>
                            </div>
                            <div class="p-3">
                                <p><span>€</span>{{ $account->balance }}</p>
                                <p>{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

</x-layout>
