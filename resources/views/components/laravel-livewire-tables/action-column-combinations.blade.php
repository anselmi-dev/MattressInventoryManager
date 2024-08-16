@props([
    'id',
    'editLink' => null,
    'deleteEmit' => null,
])
<div
    class="flex space-x-1">
    
    <x-wireui:button lime right-icon="plus" xs type="button" wire:click="$dispatch('openModal', { component: 'combinations.create-combinations-modal', arguments: {combination: {{  $id }}}})" title="{{ __('Manufacture') }}"/>

    @if (!auth()->user()->hasRole('operator'))    
        @if ($editLink)
            <x-wireui:button primary href="{{ $editLink }}" xs icon="pencil" wire:navigate title="{{ __('Edit') }}"/>
        @endif
    
        @if($deleteEmit)
            <x-wireui:button black wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $id }}, emit: '{{ $deleteEmit }}'} })" type="button" xs icon="trash" title="{{ __('Destroy') }}"/>
        @endif
    @endif
</div>
