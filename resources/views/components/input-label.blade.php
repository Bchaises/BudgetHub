@props(['value'])

<label {{ $attributes->merge(['class' => 'pl-1 block text-base text-secondary']) }}>
    {{ $value ?? $slot }}
</label>
