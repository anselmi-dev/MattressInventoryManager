@props(['label' => null, 'icon'])

<x-wireui:button {{ $attributes }} xs squared white class="group">
    @if ($icon)
        {{ $icon }}
    @endif
    
    @if ($label)
        <span class="max-w-0 overflow-hidden transition-all duration-300 group-hover:max-w-full">{{ $label }}</span>
    @else
        <span>{{ $slot }}</span>
    @endif
</x-wireui:button>