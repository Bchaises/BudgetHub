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
                    <div class="rounded-lg shadow-lg mr-12 basis-auto h-full min-w-72 max-w-96 cursor-pointer hover:shadow-2xl transition duration-300">
                        <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                            <h1 class="text-xl">{{ ucfirst($account->title) }}</h1>
                            <i class="fa-solid fa-euro-sign fa-xl"></i>
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-xl"><span>€ </span>{{ $account->balance }}</p>
                            <p>{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            <div class="flex space-x-2 items-center {{ $accountsStat[$account->id] < 0 ? 'text-red-500' : 'text-green-500' }}">
                                @if( $accountsStat[$account->id] < 0)
                                    <i class="fa-solid fa-lg fa-arrow-trend-down"></i> <p>{{ $accountsStat[$account->id]." €" }}</p>
                                @else
                                    <i class="fa-solid fa-lg fa-arrow-trend-up"></i> <p>{{ "+".$accountsStat[$account->id]." €" }}</p>
                                @endif
                                <p>from last month</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="flex mt-16">

            <div class="basis-2/3 mr-12 shadow-lg">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly expenses</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>

            </div>

            <div class="basis-1/3 shadow-lg">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly expenses by categories</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>
                <div class="flex flex-col space-y-2 p-4">
                    @foreach($expensesByCategories as $key => $expense)
                        <div class="flex justify-between">
                            <div>{{ $key }}</div>
                            <div>{{ $expense }} €</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
