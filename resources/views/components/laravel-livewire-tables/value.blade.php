@props(['value', 'tooltip' => null])

<span
    @if ($tooltip)    
        x-data="{ tooltip: '{{ $tooltip }}' }"
        x-tooltip.html="tooltip"
    @endif
    class="inline-flex gpa-0.5 items-center cursor-help">
    @isset($icon)
        <x-wireui:icon name="{{ $icon }}"  class="h-4"/>
    @endisset
    <span>{{ $value }}</span>
</span>