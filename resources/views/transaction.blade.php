<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <h1>Bienvenue dans vos transactions </h1>

    <div class="m-8">
        <table class="table-auto border-collapse rounded-lg">
            <thead>
            <tr>
                <th class="p-2 ">ID</th>
                <th class="p-2 ">label</th>
                <th class="p-2 ">amount</th>
                <th class="p-2 ">account</th>
                <th class="p-2 ">category</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <th class="p-2 ">{{ $transaction->id }}</th>
                    <th class="p-2 ">{{ $transaction->label }}</th>
                    <th class="p-2 ">{{ $transaction->amount }}€</th>
                    <th class="p-2 ">{{ $transaction->account->title }}</th>
                    <th class="p-2 ">{{ $transaction->category->title }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-layout>
