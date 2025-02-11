@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'options' => [],
    'selected' => null,
    'iconSelected' => '',
    'labelSelected' => '',
    'containerClass' => '',
    'buttonClass' => ''
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
    <div x-data="{ open: false, selected: '{{ $selected }}', iconSelected: '{{ $iconSelected }}', 'labelSelected': '{{ $labelSelected }}' }" @class([
    'relative w-40',
    $containerClass
    ])>

        <button type="button" @click="open = !open" @class([
        'w-full rounded-lg py-2 px-3 text-left bg-primary focus:outline-none transition ease-in-out duration-150 flex items-center',
        $buttonClass
        ])>
            <i :class="iconSelected"></i>
            <span class="ml-2" x-text="labelSelected"></span>
            <i class="fa-solid fa-chevron-down w-5 h-5 ml-auto"></i>
        </button>

        <input type="hidden" name="{{ $name }}" x-model="selected">

        <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-auto">
            <ul class="py-1">
                @foreach ($options as $value => $data)
                    <li @click="selected = '{{ $value }}'; open = false; iconSelected = '{{ $data['icon'] }}'; labelSelected = '{{ $data['label'] }}'" class="cursor-pointer px-4 py-2 hover:bg-gray-100 flex items-center">
                        <span class="mr-2"><i class="{{ $data['icon'] }}"></i></span>
                        <span>{{ $data['label'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('selectDropdown', (selected, options) => ({
            open: false,
            selected: selected,
            options: options
        }));
    });
</script>
