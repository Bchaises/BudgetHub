<div class="shadow-lg flex flex-col h-full">
    <div class="flex justify-between items-center border-b p-3 rounded-t-lg bg-primary">
        <h1 class="text-xl">Budget Progress for {{ now()->format('F Y') }}</h1>
        <i class="fa-solid fa-euro-sign fa-xl"></i>
    </div>
    <div class="rounded-b-lg overflow-hidden bg-white h-full">
        @if(!$budgets->isEmpty())
            <div class="flex flex-col space-y-4 p-4">
                @foreach($budgets as $index => $budget)
                    @php
                        $expenses = (double) collect($expensesByCategories)->where('id', $budget->category_id)->first()['sum'];
                        $category = $budget->category;
                        $percent = round(null !== $expenses ? $expenses / $budget->amount * 100 : 0);
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
                        class="flex flex-row items-center gap-2">
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

                <p class="text-center text-red-400">No budgets found</p>
            </div>
        @endif
    </div>
</div>
