
@props([
    'disabled' => false,
    'type' => 'text',
    'min' => 0,
    'step' => 0,
    'id' => 'amount',
    'name' => 'amount',
    'placeholder' => '0.00',
    'required' => 'false',
    'class' => ''
])
<div class="{{ $class }} flex items-center text-sm rounded-xl bg-gray-100 text-gray-600 px-2 py-3 has-[input:focus-within]:outline-none has-[input:focus-within]:ring-2 has-[input:focus-within]:ring-offset-2 has-[input:focus-within]:ring-primary transition ease-in-out duration-100">
    <div class="shrink-0 select-none">€</div>
    <input @disabled($disabled) required="{{ $required }}" placeholder="{{ $placeholder }}" type="{{ $type }}" min="{{ $min }}" step="{{ $step }}" id="{{$id }}" name="{{ $name }}" class="min-w-0 grow pl-1 pr-3 focus:outline focus:outline-0 bg-gray-100">
    <div class="grid shrink-0 grid-cols-1 focus-within:relative">
        <div class="col-start-1 row-start-1 w-full appearance-none rounded-md pl-3 pr-2.5 placeholder:text-gray-400">
            EUR
        </div>
    </div>
</div>
