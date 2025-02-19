@props([
    'type' => 'checkbox',
    'value' => '',
    'name' => '',
    'id' => null,
    'label' => '',
    'required' => true
])

<div class="mt-5 gap-2 flex relative">
    <input {{ $attributes->merge(['type' => $type, 'value' => $value, 'id' => $id !== null ? $id : $name , 'name' => $name, 'required' => $required, 'class' => 'appearance-none w-5 h-5 shrink-0 rounded bg-white text-primary border-2 border-primary checked:bg-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150 peer']) }}>
    <i class="fa-solid fa-check fs-xs absolute inset-0 w-4 h-4 hidden peer-checked:block text-white" style="pointer-events: none;left:0.20em;top:0.20em"></i>
    <label for="{{ $id !== null ? $id : $name }}" class="text-base text-police-light">{{ $label }}</label>
</div>
