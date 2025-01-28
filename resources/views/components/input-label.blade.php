@props(['value'])

<label {{ $attributes->merge(['class' => 'pl-1 block text-base text-police-light']) }}>
    {{ $value ?? $slot }}
</label>
