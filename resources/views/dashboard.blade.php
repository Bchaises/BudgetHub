<x-layout>
    <x-slot:title>
        {{ $title }}
    </x-slot>

    <h1>Bienvenue dans votre dashboard</h1>

    <p>Ici vous retrouverez les graphiques et les statistiques de vos comptes</p>

    <div>
        <a href="/transaction">Go to Transaction</a><br>
        <a href="/account">Go to Account</a>
    </div>

</x-layout>
