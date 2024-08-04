@props([
    'id',
    'editLink' => null,
    'deleteEmit' => null,
])
<div
    class="flex space-x-1">
    @if ($editLink)
        <x-wireui:button primary href="{{ $editLink }}" xs icon="pencil" wire:navigate>
        </x-wireui:button>
    @endif

    @if($deleteEmit)
        <x-wireui:button secondary x-on:click="preventDelete()" type="button" xs icon="trash">
        </x-wireui:button>
    @endif
</div>
