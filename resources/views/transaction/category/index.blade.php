<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <a href="/transaction">Retour aux transactions</a>

    <div class="flex flex-col items-center">
        <h1 class="text-xl">Les catégories de transactions</h1>
        <div class="w-2/3 flex justify-center">
            <div class="overflow-x-auto rounded-lg shadow-lg m-8 w-full basis-2/3">
                <table class="table-auto border-collapse w-full text-left text-sm bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-800 border-b">
                        <th class="p-4 font-medium">ID</th>
                        <th class="p-4 font-medium">title</th>
                        <th class="p-4 font-medium">description</th>
                        <th class="p-4 font-medium">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 text-gray-700">{{ $category->id }}</td>
                            <td class="p-4 text-gray-700">{{ $category->title }}</td>
                            <td class="p-4 text-gray-700">{{ $category->description }}</td>
                            <td class="p-4 text-gray-700 flex items-center">
                                <form method="POST" action="/transaction/category/delete/{{ $category->id }}" class="m-0">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" fill="gray" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                    </button>
                                </form>

                                <a href="/transaction/category/{{ $category->id }}" class="ml-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" fill="gray" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="m-8 w-full basis-1/3">
                <form method="POST" action="/transaction/category/store" class="flex flex-col ">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="mt-2">
                        <label for="title" class="block text-sm/6 font-medium text-gray-900">Entrez le titre de la catégorie : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="title" id="title" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">Entrez la description de la catégorie : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="description" id="description" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>


