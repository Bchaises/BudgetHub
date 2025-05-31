<x-app-layout :notifications="$notifications">

    <x-slot:title>{{ __("Here, your account settings") }}</x-slot:title>

    <!-- Accounts navigation -->
    <section>
        <a href="{{ route('account.show', ['id' => $account->id]) }}">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
    </section>

    <div class="py-12">
        <div class="grid lg:grid-cols-12 gap-10 items-stretch">

            <div class="lg:col-span-5">
                @include('account.partials.update-account-information-form')
            </div>

            <div class="lg:col-span-7">
                @include('account.partials.invite-form')
            </div>

            <div class="lg:col-span-7">
                @include('account.partials.update-budget-form')
            </div>

            <div class="lg:col-span-5">
                @include('account.partials.delete-account-form')
            </div>
        </div>
    </div>
</x-app-layout>
