<div class="w-full px-4 pb-4 pt-5 sm:p-6 flex flex-col | relative space-y-2">

    <div class="flex items-center justify-between">
        <span>
            {{ __('Import Sales') }}
        </span>

        <x-wireui:button href="{{ asset('files/ventas-test.xlsx') }}" download="ventas-test.xlsx" flat sm title="ventas-test.xlsx">
            {{ __('Download test document') }}
        </x-wireui:button>
    </div>

    <div class="flex text-xs text-gray-400">
        <p>{{ __('Drag or upload a .xlsx document to import sales. Ensure that the product codes match those in the system to correctly update the stock.') }}</p>
    </div>
    
    <div class="w-full">
        <x-loading-livewire/>
        
        <x-filepond
            wire:model="file"
            allowImagePreview
            allowFileTypeValidation
            acceptedFileTypes="['application/csv', 'text/csv', 'text/comma-separated-values']"
            allowFileSizeValidation
            maxFileSize="4mb" />
    </div>

    <x-wireui:errors/>

    <div class="w-full | flex justify-end gap-2">
        <x-wireui:button black wire:click="$dispatch('closeModal')" sm>
            {{ __('Cancel') }}
        </x-wireui:button>
        <x-wireui:button type="button" primary wire:click="submit" sm right-icon="chevron-right">
            {{ __('Importar') }}
        </x-wireui:button>
    </div>
</div>

