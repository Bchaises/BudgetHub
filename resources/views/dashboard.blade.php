<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ "Hi, Welcome back ".strtolower($user->name)." 👋!" }}</x-slot:title>

    <div class="mb-8">
        <div class="flex gap-6 flex-wrap">
            @foreach($accounts as $account)
                <a href="{{ route('account.show', ['id' => $account->id]) }}">
                    <div class="rounded-lg shadow-lg basis-auto h-full w-72 cursor-pointer hover:shadow-xl transition duration-300 bg-white">
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

        <div class="grid lg:grid-cols-12 gap-6 mt-6">

            <div class="lg:col-span-8">
                <livewire:monthly-transaction-by-category-chart />
            </div>

            <div class="lg:col-span-4 shadow-lg rounded-lg overflow-hidden bg-white">
                <div class="flex justify-between items-center border-b p-3 bg-primary">
                    <h1 class="text-xl">Expenses by categories this month</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>


                @if(isset($expensesByCategories))
                    @if(count($expensesByCategories) > 0)
                        @php
                            $total = $expensesByCategories->sum('amount');
                            $currentOffset = 0;
                        @endphp

                        <div class="p-4 space-y-3 text-sm">
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
                        </div>
                    @else
                        <div class="flex flex-col gap-2 justify-center items-center h-full">
                            <div style="height: 43px; width: 43px;" class="flex justify-center items-center rounded-full bg-red-400">
                                <i class="fa-solid fa-2xl fa-xmark text-white"></i>
                            </div>

                            <p class="text-center text-red-400">Nothing on {{ date('M Y') }}</p>
                        </div>
                    @endif
                @endif
            </div>

            <div class="lg:col-span-4 shadow-lg rounded-lg overflow-hidden bg-white">
                <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
                    <h1 class="text-xl">Monthly Budget</h1>
                    <i class="fa-solid fa-euro-sign fa-xl"></i>
                </div>
                    @if(!$accounts->first()->budgets->isEmpty())
                        <div class="flex flex-col space-y-4 p-4">
                            @foreach($accounts->first()->budgets as $budget)
                                @php
                                    $expenses = (double) $expensesByCategories->where('id', '==', $budget->category_id)->first()?->amount;
                                    $category = $budget->category;
                                    $percent = null !== $expenses ? $expenses / $budget->amount * 100 : 0;
                                @endphp
                                <div class="flex flex-row items-center gap-2">
                                    <div style="height: 43px; width: 43px; background-color: {{ $category->color }};" class="flex justify-center items-center rounded-full">
                                        <i class="fa-solid fa-xl text-white {{ $category->icon }}"></i>
                                    </div>

                                    <div class="relative flex flex-col flex-1 gap-2">
                                        <div class="flex flex-row justify-between">
                                            <p>{{ $category->title }}</p>
                                            <p>{{ $percent }}%</p>
                                        </div>

                                        <div class="relative w-full h-2.5 rounded-full overflow-hidden bg-gray-200">
                                            <div class="absolute top-0 h-full"
                                                 style="
                                    width: {{ $percent }}%;
                                    background-color: {{ $category->color }};
                                    "
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col gap-2 justify-center items-center h-full">
                            <div style="height: 43px; width: 43px;" class="flex justify-center items-center rounded-full bg-red-400">
                                <i class="fa-solid fa-2xl fa-xmark text-white"></i>
                            </div>

                            <p class="text-center text-red-400">No budgets to show</p>
                        </div>
                    @endif
            </div>

            <div class="lg:col-span-8 shadow-lg rounded-lg overflow-hidden bg-white">
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
                    const credits = @json($monthlyExpenses['monthlyCredits']);
                    const debits = @json($monthlyExpenses['monthlyDebits']);
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: months2,
                            datasets: [
                                {
                                    label: 'Crédits',
                                    data: credits,
                                    backgroundColor: 'rgba( 236, 112, 99, 1)',
                                    borderRadius: 4,
                                    barPercentage: 0.75
                                },
                                {
                                    label: 'Débits',
                                    data: debits,
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
