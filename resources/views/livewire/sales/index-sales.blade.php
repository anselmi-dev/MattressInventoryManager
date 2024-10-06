<x-page.container>
    <x-page.heading title="{{ __('Sales') }}" breadcrumbs="sales">
        <x-slot name="actions">
            {{--
            @if (!auth()->user()->hasRole(['operator']))    
                <div class="flex flex-wrap gap-1">
                    <x-wireui:button primary right-icon="plus" wire:click="$dispatch('openModal', { component: 'sales.import-sales-modal'})">
                        {{ __('Importar') }}
                    </x-wireui:button>
                </div>
            @endif
            --}}
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

{{-- 
@push('scripts')
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
@endpush
--}}
