<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ "Hi, Welcome back ".strtolower($user->name)." 👋!" }}</x-slot:title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="w-full">
        <div class="flex flex-wrap">
            @foreach($accounts as $account)
                <a href="{{ route('account.show', ['id' => $account->id]) }}">
                    <div class="rounded-lg shadow-lg mr-6 basis-auto h-full w-72 cursor-pointer hover:shadow-xl transition duration-300 bg-white">
                        <div class="flex justify-between items-center border-b px-2 py-1 rounded-t-lg bg-primary">
                            <h1 class="">{{ ucfirst($account->title) }}</h1>
                            <i class="fa-solid fa-euro-sign"></i>
                        </div>
                        <div class="px-4 py-2 flex flex-col justify-center">
                            <p class="text-2xl font-bold"><span>€ </span>{{ number_format($account->balance, 2, ',', ' ') }}</p>
                            <p class="text-sm">{{ strlen($account->description) > 50 ? substr($account->description,0, 50). '...' : $account->description }}</p>
                            @if($accountsStat[$account->id] !== 0)
                                <div class="flex text-xs space-x-2 items-center {{ $accountsStat[$account->id] < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    @if( $accountsStat[$account->id] < 0)
                                        <i class="fa-solid fa-lg fa-arrow-trend-down"></i> <p>{{ str_replace('-', '- ', number_format((float) $accountsStat[$account->id], 2, ',', ' '))." €" }}</p>
                                    @elseif( $accountsStat[$account->id] > 0)
                                        <i class="fa-solid fa-lg fa-arrow-trend-up"></i> <p>{{ "+ ".number_format((float) $accountsStat[$account->id], 2, ',', ' ')." €" }}</p>
                                    @endif
                                    <p>from last month</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach

            <div class="flex items-center">
                <button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'account-creation')"
                    type="button"
                    class="bg-gray-200 p-2 rounded-lg w-10 h-10 cursor-pointer flex items-center justify-center"
                ><i class="fa-solid fa-plus"></i></button>

                <x-modal
                    class="absolute"
                    title="{{ __('Create a new account') }}"
                    name="account-creation" :show="$errors->accountCreation->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('account.store') }}" class="p-10">
                        @csrf
                        @method('post')

                        <p class="mt-1 text-xl text-gray-600">
                            {{ __('Complete the following fields : ') }}
                        </p>

                        <div class="mt-8">

                            <x-text-input
                                id="title"
                                name="title"
                                type="text"
                                class="mt-4 block w-full"
                                placeholder="{{ __('Title') }}"
                                required
                            />

                            <x-input-error :messages="$errors->accountCreation->get('title')" class="mt-2" />

                            <x-text-input
                                id="description"
                                name="description"
                                type="text"
                                class="mt-4 block w-full"
                                placeholder="{{ __('Description') }}"
                            />

                            <x-input-error :messages="$errors->accountCreation->get('description')" class="mt-2" />

                            <x-money-input
                                id="balance"
                                name="balance"
                                type="number"
                                min="0"
                                step="0.01"
                                class="mt-4 block w-full"
                                placeholder="0.00"
                                required
                            />

                            <x-input-error :messages="$errors->accountCreation->get('balance')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <x-primary-button class="flex flex-1 justify-center" x-on:click="$dispatch('close')" type="button">
                                {{ __('Cancel') }}
                            </x-primary-button>

                            <x-primary-button type="submit" class="flex flex-1 justify-center">
                                {{ __('Create Account') }}
                            </x-primary-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>

        <div class="flex mt-6">

            <livewire:monthly-transaction-by-category-chart />

            <div class="basis-1/3 shadow-lg rounded-lg overflow-hidden bg-white">
                <div class="flex justify-between items-center border-b p-3 bg-primary">
                    <h1 class="text-xl">Expenses by categories this month</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>
                <div class="p-4 space-y-3 text-sm">

                @if(isset($expensesByCategories))
                    @if(count($expensesByCategories) > 0)
                        @php
                            $total = $expensesByCategories->sum('amount');
                            $currentOffset = 0;
                        @endphp

                        <div class="relative w-full h-2.5 rounded-full overflow-hidden bg-gray-200">
                            @foreach($expensesByCategories as $cat)
                                @php
                                    $percent = $total > 0 ? ($cat->amount / $total * 100) : 0;
                                    $left = $currentOffset;
                                    $currentOffset += $percent;
                                @endphp
                                <div class="absolute top-0 h-full"
                                     style="
                                width: {{ $percent }}%;
                                left: {{ $left }}%;
                                background-color: {{ $cat->color }};
                                "
                                     title="{{ $cat->title }} ({{ round($percent) }}%)"
                                ></div>
                            @endforeach
                        </div>

                        @foreach($expensesByCategories as $cat)
                            @php
                                $percent = $total > 0 ? round($cat->amount / $total * 100) : 0;
                            @endphp
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $cat->color }}"></span>
                                    <span>{{ $cat->title }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-400">{{ number_format($cat->amount, 2, ',', ' ') }} €</span>
                                    <span class="font-bold">{{ $percent }}%</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="m-auto text-center">
                            <p>Nothing on {{ date('M Y') }}</p>
                        </div>
                    @endif
                @endif
                </div>
            </div>
        </div>

        <div class="flex my-6">
            <div class="basis-1/3 shadow-lg mr-6 rounded-lg overflow-hidden bg-white">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly Budget</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>
                <div class="flex flex-col space-y-2 p-4">

                </div>
            </div>

            <div class="basis-2/3 shadow-lg rounded-lg overflow-hidden bg-white">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly expenses</h1>
                    <i class="fa-solid fa-chart-simple fa-xl"></i>
                </div>

                <div class="p-2">
                    <canvas id="myChart2"></canvas>
                </div>

                <script>
                    const ctx2 = document.getElementById('myChart2');
                    const months2 = [
                        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                    ];
                    const credits2 = [1000, 800, 1200, 900, 1100, 950, 1300, 1250, 1400, 1000, 1050, 1150];
                    const debits2 = [700, 600, 900, 500, 800, 750, 1000, 950, 1100, 800, 850, 950];
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: months2,
                            datasets: [
                                {
                                    label: 'Crédits',
                                    data: credits2,
                                    backgroundColor: 'rgba( 236, 112, 99, 1)',
                                    borderRadius: 4,
                                    barPercentage: 0.75
                                },
                                {
                                    label: 'Débits',
                                    data: debits2,
                                    backgroundColor: 'rgba( 93, 173, 226 , 1)',
                                    borderRadius: 4,
                                    barPercentage: 0.75
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
