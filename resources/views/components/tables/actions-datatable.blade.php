<div class="flex items-center gap-1">
    <x-button icon="pencil" primary xs wire:click="editModel({{ $value }})">
        <span class="hidden xl:inline-block">{{__('Editar')}}</span>
    </x-button>
    <x-button icon="x" negative xs wire:click="preventDelete({{ $value }})">
        <span class="hidden xl:inline-block">{{__('Eliminar')}}</span>
    </x-button>
</div>
