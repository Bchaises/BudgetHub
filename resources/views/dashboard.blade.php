<x-app-layout>
    <div class="m-2 flex justify-between items-center">
        <div>
            <h1 class="text-2xl mb-1">Bonjour 👋 {{ strtolower($user->name) }} ! Bienvenue dans votre dashboard.</h1>
            <p class="text-md">Ici vous retrouverez les graphiques et les statistiques de vos comptes</p>
        </div>

        <div class="flex">
            <form method="POST" action="{{ route('logout') }}" class="mr-2">
                @csrf

                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </a>
            </form>

            <div>
                <x-button title="Transaction" link="{{ route('transaction.index') }}"/>
                <x-button title="Account" link="{{ route('account.index') }}"/>
                <x-button title="Invitation" link="{{ route('invitation.index') }}"/>
            </div>
        </div>
    </div>

    <div class="w-full mt-8 flex justify-center">
        <div class="w-2/3">
            <div class="flex flex-wrap">
                @foreach($accounts as $account)
                    <a href="{{ route('account.show', ['id' => $account->id]) }}">
                        <div class="rounded-lg shadow-lg mx-4 basis-auto h-full min-w-72 max-w-96 cursor-pointer hover:shadow-2xl transition duration-300">
                            <div class="border-b p-4 rounded-t-lg bg-primary">
                                <h1 class="text-xl">{{ ucfirst($account->title) }}</h1>
                            </div>
                            <div class="p-4">
                                <p><span>€</span>{{ $account->balance }}</p>
                                <p>{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
