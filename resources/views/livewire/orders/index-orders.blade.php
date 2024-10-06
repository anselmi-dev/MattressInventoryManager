<x-page.container>
    <x-page.heading title="{{ __('Orders') }}" breadcrumbs="orders">
        <x-slot name="actions">
            @if (!auth()->user()->hasRole(['operator']))
                <x-wireui:button
                    x-data="{ tooltip: '{{ __('Request more stock of the product by generating a new order.') }}' }"
                    x-tooltip="tooltip"
                    wire:click="$dispatch('openModal', { component: 'orders.generate-order-modal', arguments: {product_ids: []}})"
                    type="button"
                    icon="plus">
                    <span>
                        {{ __('Generate order') }}
                    </span>
                </x-wireui:button>
            @endif
        </x-slot>
    </x-page.heading>

    <x-page.content>
        @include('livewire-tables::datatable')
    </x-page.content>
</x-page.container>

@push('styles')
    <style>
        thead th:last-child {
            width: 0px
        }
    </style>
@endpush
