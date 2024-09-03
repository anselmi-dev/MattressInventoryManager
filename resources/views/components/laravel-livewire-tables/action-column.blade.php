@props([
    'id',
    'editLink' => null,
    'deleteEmit' => null,
    'order' => null,
    'manufacture' => null,
    'showLink' => null,
])

<div
    x-data="{
        show: false
    }"
    x-cloak
    x-on:mouseenter="show = true"
    x-on:mouseleave="show = false"
    class="flex space-x-1 relative">
    
    <button
        type="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
        </svg>
    </button>

    <div x-show="show" class="flex items-center gap-1 absolute right-full h-full pl-2">
        <span class="isolate inline-flex rounded-md shadow-sm border border-gray-400 overflow-hidden">

            @if ($manufacture)
                <button
                    x-data="{ tooltip: '{{ __('Manufacture') }}' }"
                    x-tooltip="tooltip"
                    wire:click="$dispatch('openModal', { component: 'combinations.create-combinations-modal', arguments: {combination: {{  $id }}}})"
                    type="button"
                    class="relative inline-flex items-center bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                    <x-wireui:icon name="plus" class="h-4"/>
                    <span>
                        {{ __('Manufacture') }}
                    </span>
                </button>
            @endif
            
            @if ($order)
                <button
                    x-data="{ tooltip: '{{ __('Request more stock of the product by generating a new order.') }}' }"
                    x-tooltip="tooltip"
                    wire:click="$dispatch('openModal', { component: 'orders.generate-order-modal', arguments: {product_ids: {{  $id }}}})"
                    type="button"
                    class="relative inline-flex items-center bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                    <x-wireui:icon name="plus" class="h-4"/>
                    <span>
                        {{ __('Generate order') }}
                    </span>
                </button>
            @endif

            @if ($showLink)
                <a
                    x-data="{ tooltip: '{{ __('Show') }}' }"
                    x-tooltip="tooltip"
                    href="{{ $showLink }}"
                    wire:navigate
                    class="relative inline-flex items-center bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                    <x-wireui:icon name="magnifying-glass" class="h-4"/>
                </a>
            @endif
            
            @if($deleteEmit)
                <button
                    x-data="{ tooltip: '{{ __('Destroy') }}' }"
                    x-tooltip="tooltip"
                    wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $id }}, emit: '{{ $deleteEmit }}'} })"
                    type="button"
                    class="relative -ml-px inline-flex items-center bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                    <x-wireui:icon name="trash" class="h-4"/>
                    <span class="hidden _md:inline-block">
                        {{ __('Destroy') }}
                    </span>
                </button>
            @endif

            @if ($editLink)
                <a
                    x-data="{ tooltip: 'Editar' }"
                    x-tooltip="tooltip"
                    wire:navigate
                    href="{{ $editLink }}"
                    class="relative -ml-px inline-flex items-center bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10">
                    <x-wireui:icon name="pencil" class="h-4"/>
                    <span class="hidden _md:inline-block">
                        {{ __('Edit') }}
                    </span>
                </a>
            @endif
        </span>          
    </div>
</div>
