<x-page.container>
    <x-page.heading title="{{ __('Manufacture Special Measures') }}" breadcrumbs="manufacture-special-measures">
        <x-slot name="actions">
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
