<aside class="hidden fixed top-0 left-0 h-screen md:flex flex-col items-center text-primary-dark bg-white shadow-md">
    <div class="h-16 my-4 flex justify-center items-center w-full">
        <a class="h-10 w-10" href="{{ route('home') }}">
            <i class="fa-solid fa-piggy-bank text-4xl"></i>
        </a>
    </div>

    <ul>
        <x-sidebar-link route="dashboard" icon="fa-solid fa-chart-pie" label="Dashboard" activeRoute="dashboard" />
        <x-sidebar-link route="account.show" icon="fa-solid fa-wallet" label="Accounts" activeRoute="account" />
        <x-sidebar-link route="transfer.index" icon="fa-solid fa-arrow-right-arrow-left" label="Transfer" activeRoute="transfer" />
        <x-sidebar-link route="profile.edit" icon="fa-solid fa-user" label="Profile" activeRoute="profile" />
        <x-sidebar-link route="dashboard" icon="fa-solid fa-gear" label="Settings" activeRoute="setting" />
    </ul>
</aside>
