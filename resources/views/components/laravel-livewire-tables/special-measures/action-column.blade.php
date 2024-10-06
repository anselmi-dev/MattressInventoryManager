@props([
    'id'
])


<x-wireui:button
    x-data="{ tooltip: '{{ __('Manufacture') }}' }"
    x-tooltip="tooltip"
    wire:click="$dispatch('openModal', { component: 'special-measures.manufacture-special-measures-modal', arguments: {productSale: {{  $id }}}})"
    type="button"
    primary
    sm
    icon="plus">
    {{ __('Manufacture') }}
</x-wireui:button>