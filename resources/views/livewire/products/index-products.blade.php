<x-page.container>
    <x-page.heading title="{{ __('Parts') }}" breadcrumbs="parts">
        <x-slot name="actions">
            @if (!auth()->user()->hasRole(['operator']))    
                <div class="flex flex-wrap gap-1">
                    <x-wireui:button primary right-icon="plus" href="{{ route('products.model', ['model' => null]) }}" wire:navigate>
                        {{ __('Crear') }}
                    </x-wireui:button>

                    <x-wireui:button black right-icon="plus" wire:click="$dispatch('openModal', { component: 'products.import-products-modal'})">
                        {{ __('Importar') }}
                    </x-wireui:button>
                </div>
            @endif
        </x-slot>
    </x-page.heading>

    <x-page.content>
        @include('livewire-tables::datatable')
    </x-page.content>
</x-page.container>

@push('styles')
    <style>
        thead tr th:last-child {
            width: 0px
        }
    </style>
@endpush
