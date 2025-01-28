<x-app-layout>

    <x-slot:title>{{ "Here, your invitations" }}</x-slot:title>

    <div>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </div>

    <div class="flex flex-col items-center">
        <div class="w-2/3 flex justify-center">
            <div class="overflow-x-auto rounded-lg shadow-lg m-8 w-full basis-2/3">
                <table class="table-auto border-collapse w-full text-left text-sm bg-white">
                    <thead>
                    <tr class="bg-gray-100 text-gray-800 border-b">
                        <th class="p-4 font-medium">ID</th>
                        <th class="p-4 font-medium">Account</th>
                        <th class="p-4 font-medium">Receiver</th>
                        <th class="p-4 font-medium">Sender</th>
                        <th class="p-4 font-medium">Status</th>
                        <th class="p-4 font-medium">Role</th>
                        <th class="p-4 font-medium">Expired at</th>
                        <th class="p-4 font-medium">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invitations as $invitation)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 text-gray-700">{{ $invitation->id }}</td>
                            <td class="p-4 text-gray-700">{{ $invitation->account->title }}</td>
                            <td class="p-4 text-gray-700">{{ $invitation->receiver->name }}</td>
                            <td class="p-4 text-gray-700">{{ $invitation->sender->name }}</td>
                            <td class="p-4 text-gray-700">{{ $invitation->status }}</td>
                            <td class="p-4 text-gray-700">{{ $invitation->role }}</td>
                            <td class="p-4 text-gray-700">{{ $invitation->expired_at }}</td>
                            <td class="p-4 text-gray-700 flex items-center">
                                <form method="POST" action="{{ route('invitation.destroy', ['invitation' => $invitation->id]) }}" class="m-0">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" fill="gray" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="m-8 w-full basis-1/3">
                <form method="POST" action="{{ route('invitation.store') }}" class="flex flex-col ">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="mt-2">
                        <label for="receiver_email" class="block text-sm/6 font-medium text-gray-900">E-mail de l'utilisateur : </label>
                        <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <input type="email" name="receiver_email" id="receiver_email" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
                        </div>
                        <x-input-error :messages="$errors->get('receiver_email')" class="mt-2" />
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="account" class="block text-sm/6 font-medium text-gray-900">Sélectionnez un compte :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="account" id="account" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('account')" class="mt-2" />
                    </div>

                    <div class="mt-2 flex flex-col">
                        <label for="role" class="block text-sm/6 font-medium text-gray-900">Avec quel rôle :</label>
                        <div class="mt-2 flex items-center rounded-md bg-white px-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                            <select name="role" id="role" class="block min-w-0 grow py-2 pl-1 pr-3 text-base bg-white text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6">
                                    <option value="editor">Editor</option>
                                    <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 px-4 rounded-lg">Sauvegarder</button>
                        @if(session('status') === 'invitation-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('An invitation link has been sent.') }}
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


