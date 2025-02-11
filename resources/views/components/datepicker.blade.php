@props([
    'name' => '',
    'id' => '',
    'class' => '',
])

<div {{ $class }}>
    @isset($label)
        <label for="{{ $name }}" class="block text-sm/6 font-medium text-gray-900">{{ $label }}</label>
    @endisset
    <div class="mt-2 flex items-center rounded-md bg-white pl-3 outline outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
        <input type="date" value="{{ date('Y-m-d') }}" name="{{ $name }}" id="{{ $id ?? $name }}" class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6" required>
    </div>
</div>
