<section class="h-full">
    <div class="bg-white shadow sm:rounded-lg overflow-hidden h-full flex flex-col">
        <header>
            <div class="p-4 bg-primary flex items-center justify-between overflow-hidden">
                <i class="fa-solid fa-paper-plane"></i>
                <h1 class="text-xl text-police flex-1 text-center">{{ __('Invite someone') }}</h1>
            </div>
        </header>

        <div x-data class="p-4 sm:p-8 flex flex-col flex-grow"> <!-- make parent flex -->
            <form method="post" action="{{ route('invitation.store') }}" class="flex flex-col flex-grow justify-between">
                @csrf
                @method('post')

                <div class="flex flex-col gap-8 flex-grow"> <!-- make inputs grow -->
                    <div>
                        <x-input-label for="receiver_mail" :value="__('Email')" />
                        <x-text-input id="receiver_email" name="receiver_email" type="email" class="mt-1 block w-full" placeholder="john.doe@example.com" required autocomplete="email" />
                    </div>

                    <input hidden name="account" value="{{ $account->id }}"/>
                    <input hidden name="role" value="editor"/>

                    <div class="flex flex-wrap">
                        @foreach($invitations as $key => $invitation)
                            @if(($key+1) % 2 == 0)
                                <div class="border border-primary mx-2"></div>
                            @endif
                            <div class="flex items-center gap-2">
                                <p>{{ $invitation->receiver->email }}</p>
                                <div class="px-2 py-1 bg-gray-200 rounded-lg text-xs">{{ $invitation->status }}</div>
                                <button
                                    type="button"
                                    @click="$refs.invitationDestroyForm.action = '{{ route('invitation.destroy', ['invitation' => $invitation]) }}'; $refs.invitationDestroyForm.submit();"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-4">
                    <x-primary-button type="submit" class="lg:w-32 w-full justify-center">{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'invitation-sent')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        ><i class="fa-solid fa-check pr-2"></i>{{ __('Sent.') }}</p>
                    @endif
                </div>
            </form>
            <form x-ref="invitationDestroyForm" method="POST" class="hidden">
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
</section>
