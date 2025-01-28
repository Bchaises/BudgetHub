<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2.5 bg-gray-200 border border-transparent rounded-xl text-base text-police-light tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
