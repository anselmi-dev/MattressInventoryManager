<x-laravel-livewire-tables.action-column.container class="grid grid-cols-[0px_minmax(51px,_3fr)_100px] h-[20px]">
    <div class="aboslute top-0 left-0">
        <x-laravel-livewire-tables.action-column.action label="{{ __('Manufacture') }}" wire:click="$dispatch('openModal', { component: 'combinations.create-combinations-modal', arguments: {combination: {{  $id }}}})">
            <x-slot name="icon">
                <x-wireui:icon name="plus" class="h-4"/>
            </x-slot>
        </x-laravel-livewire-tables.action-column.action>
        <x-laravel-livewire-tables.action-column.action label="{{ __('Edit') }}" href="{{ $editLink }}" wire:navigate>
            <x-slot name="icon">
                <x-wireui:icon name="pencil" class="h-4"/>
            </x-slot>
        </x-laravel-livewire-tables.action-column.action>
        <x-laravel-livewire-tables.action-column.action label="{{ __('Destroy') }}" wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $id }}, emit: '{{ $deleteEmit }}'} })">
            <x-slot name="icon">
                <x-wireui:icon name="trash" class="h-4"/>
            </x-slot>
        </x-laravel-livewire-tables.action-column.action>
    </div>
</x-laravel-livewire-tables.action-column.container>