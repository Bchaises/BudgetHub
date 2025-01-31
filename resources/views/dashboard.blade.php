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
                        <div class="px-4 py-2">
                            <p><span>€</span>{{ $account->balance }}</p>
                            <p>{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            <div class="flex space-x-2 items-center {{ $accountsStat[$account->id] < 0 ? 'text-red-500' : 'text-green-500' }}">
                                @if( $accountsStat[$account->id] < 0)
                                    <i class="fa-solid fa-lg fa-arrow-trend-down"></i> <p class="font-bold">{{ $accountsStat[$account->id]." €" }}</p>
                                @else
                                    <i class="fa-solid fa-lg fa-arrow-trend-up"></i> <p class="font-bold">{{ "+".$accountsStat[$account->id]." €" }}</p>
                                @endif
                                <p>from last month</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
