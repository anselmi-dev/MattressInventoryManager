@props([
    'id',
    'editLink' => null,
    'deleteEmit' => null,
    'order' => null,
    'manufacture' => null,
    'showLink' => null,
])

<div>
    <span class="inline-flex rounded-md border border-gray-400 overflow-hidden">
        @if ($manufacture)
            <button
                x-data="{ tooltip: '{{ __('Manufacture') }}' }"
                x-tooltip="tooltip"
                wire:click="$dispatch('openModal', { component: 'combinations.create-combinations-modal', arguments: {combination: {{  $id }}}})"
                type="button"
                class="relative inline-flex items-center bg-white px-1 py-1 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                <x-wireui:icon name="plus" class="h-4"/>
            </button>
        @endif
        
        @if ($order)
            <button
                x-data="{ tooltip: '{{ __('Request more stock of the product by generating a new order.') }}' }"
                x-tooltip="tooltip"
                wire:click="$dispatch('openModal', { component: 'orders.generate-order-modal', arguments: {product_ids: {{  $id }}}})"
                type="button"
                class="relative inline-flex items-center bg-white px-1 py-1 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                <x-wireui:icon name="plus" class="h-4"/>
            </button>
        @endif

        @if ($showLink)
            <a
                x-data="{ tooltip: '{{ __('Show') }}' }"
                x-tooltip="tooltip"
                href="{{ $showLink }}"
                wire:navigate
                class="relative inline-flex items-center bg-white px-1 py-1 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                <x-wireui:icon name="magnifying-glass" class="h-4"/>
            </a>
        @endif
        
        @if($deleteEmit)
            <button
                x-data="{ tooltip: '{{ __('Destroy') }}' }"
                x-tooltip="tooltip"
                wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $id }}, emit: '{{ $deleteEmit }}'} })"
                type="button"
                class="relative -ml-px inline-flex items-center bg-white px-1 py-1 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                <x-wireui:icon name="trash" class="h-4"/>
            </button>
        @endif

        @if ($editLink)
            <a
                x-data="{ tooltip: 'Editar' }"
                x-tooltip="tooltip"
                wire:navigate
                href="{{ $editLink }}"
                class="relative -ml-px inline-flex items-center bg-white px-1 py-1 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                <x-wireui:icon name="pencil" class="h-4"/>
            </a>
        @endif
    </span>     
</div>