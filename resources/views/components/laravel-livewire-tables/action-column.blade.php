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
        <x-wireui:button secondary wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $id }}, emit: '{{ $deleteEmit }}'} })" type="button" xs icon="trash">
        </x-wireui:button>
    @endif
</div>
