<x-app-layout>

    <div class="m-4">
        <a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('transaction.index') }}">/Transactions</a><a href="{{ route('category.index') }}">/Categories</a>
    </div>

    <div class="flex flex-col items-center">
        <h1 class="text-xl">Vous êtes sur la catégorie {{ $category->title }}</h1>
        <div class="w-2/3">
            <div class="m-8">
                <form method="POST" action="{{ route('category.update', ['id' => $category->id]) }}" class="flex flex-col ">
                    @csrf <!-- {{ csrf_field() }} -->
                    @method('PATCH')
                    <div class="mt-2">
                        <label for="title" class="block text-sm/6 font-medium text-gray-900">Modifiez le titre de la catégorie : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="title" id="title" value="{{ $category->title }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label for="description" class="block text-sm/6 font-medium text-gray-900">Entrez la description de ce compte : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="text" name="description" id="description" value="{{ $category->description }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

