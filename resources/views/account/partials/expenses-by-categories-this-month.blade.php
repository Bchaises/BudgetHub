<div class="flex justify-between items-center border-b p-3 bg-primary">
    <h1 class="text-xl">Spending by Category for {{ now()->format('F Y') }}</h1>
    <i class="fa-solid fa-euro-sign fa-xl"></i>
</div>
@if(isset($expensesByCategories))
    @if(count($expensesByCategories) > 0)
        @php
            $total = $expensesByCategories->sum('amount');
            $currentOffset = 0;
        @endphp

        <div
            class="p-4 space-y-3 text-sm">
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

            @foreach($expensesByCategories as $index => $cat)
                @php
                    $percent = $total > 0 ? round($cat->amount / $total * 100) : 0;
                    $delay = $index * 200;
                @endphp
                <div
                    x-data="{ show: false }"
                    x-init="
                                    setTimeout(() => {
                                        show = true;
                                    }, {{ $delay }});
                                    "
                    x-show="show"
                    x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="flex justify-between items-center">
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
