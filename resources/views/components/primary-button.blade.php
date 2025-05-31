<button {{ $attributes->merge([ 'type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2.5 bg-primary border border-transparent rounded-xl text-base tracking-widest hover:bg-primary-dark focus:bg-primary active:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
