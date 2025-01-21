@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'px-2 py-3 text-sm text-gray-600 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-100']) }}>
