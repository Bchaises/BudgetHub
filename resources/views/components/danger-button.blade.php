<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2.5 bg-danger border border-transparent rounded-xl text-white text-police-light tracking-widest hover:bg-danger-dark focus:bg-danger active:bg-danger focus:outline-none focus:ring-2 focus:ring-danger focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
