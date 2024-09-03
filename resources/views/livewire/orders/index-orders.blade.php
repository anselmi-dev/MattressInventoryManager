<x-page.container>
    <x-page.heading title="{{ __('Orders') }}" breadcrumbs="orders">
        <x-slot name="actions">
            <div class="flex flex-wrap gap-1">
            </div>
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
