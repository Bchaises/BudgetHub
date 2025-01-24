<x-app-layout>

    <div class="m-4">
        <a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('transaction.index') }}">/Transactions</a>
    </div>

    <div class="flex flex-col items-center">
        <h1 class="text-xl">Les catégories de transactions</h1>
        <div class="w-2/3 flex justify-center">
            <div class="overflow-x-auto rounded-lg shadow-lg m-8 w-full basis-2/3">
                <table class="table-auto border-collapse w-full text-left text-sm bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-800 border-b">
                        <th class="p-4 font-medium">ID</th>
                        <th class="p-4 font-medium">Icon</th>
                        <th class="p-4 font-medium">Title</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 text-gray-700">{{ $category->id }}</td>
                            <td class="p-4 text-white">
                                <div class="rounded-full w-9 h-9 flex justify-center items-center" style="background-color: {{ $category->color }}">
                                    <i class="fas {{ $category->icon }} fa-xl"></i>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700">{{ $category->title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>


