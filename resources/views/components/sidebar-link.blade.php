<li class="relative group">
    <a href="{{ route($route) }}"
       class="h-16 px-6 flex justify-center items-center w-full duration-200 ease-in-out hover:scale-150
       {{ Request::is($activeRoute . '*') ? 'scale-150' : 'hover:scale-150' }}">
        <i class="{{ $icon }} fa-xl drop-shadow-sm"></i>
    </a>
    <span class="absolute left-full ml-2 top-1/2 transform -translate-y-1/2 bg-gray-300 text-white text-xs p-1 rounded-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        {{ $label }}
    </span>
</li>
