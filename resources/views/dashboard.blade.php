<x-app-layout>

    <x-slot:title>{{ "Hi, Welcome back ".strtolower($user->name)." 👋!" }}</x-slot:title>

    <div class="w-full mt-8">
        <div class="mb-8">
            <form method="POST" action="{{ route('logout') }}" class="mr-2">
                @csrf

                <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </a>
            </form>
        </div>

        <div class="flex flex-wrap">
            @foreach($accounts as $account)
                <a href="{{ route('account.show', ['id' => $account->id]) }}">
                    <div class="rounded-lg shadow-lg mr-8 basis-auto h-full min-w-72 max-w-96 cursor-pointer hover:shadow-2xl transition duration-300">
                        <div class="border-b p-4 rounded-t-lg bg-primary">
                            <h1 class="text-xl">{{ ucfirst($account->title) }}</h1>
                        </div>
                        <div class="p-4">
                            <p><span>€</span>{{ $account->balance }}</p>
                            <p>{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            <p>{{ $AccountsStat[$account->id] < 0 ? 'Diminution de '. $AccountsStat[$account->id] : 'Augmentation de +'.$AccountsStat[$account->id] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
