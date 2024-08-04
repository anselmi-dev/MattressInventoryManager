<x-page.container>
    <x-page.heading title="{{ __('Tops') }}" breadcrumbs="tops">
        <x-slot name="actions">
            <div class="flex flex-wrap gap-1">
                <x-wireui:button primary right-icon="plus" href="{{ route('tops.model', ['model' => null]) }}" wire:navigate>
                    {{ __('Crear') }}
                </x-wireui:button>
            </div>
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
