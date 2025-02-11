@props([
    'slot' => '',
    'type' => 'submit',
    'class' => '',
])

<button type="{{ $type }}" class="inline-flex items-center px-2 py-2.5 bg-primary border border-transparent rounded-xl text-base text-police-light tracking-widest hover:bg-primary-dark focus:bg-primary active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 {{ $class }}">
    {{ $slot }}
</button>
