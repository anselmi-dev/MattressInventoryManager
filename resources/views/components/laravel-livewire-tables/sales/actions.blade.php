@props([
    'id',
    'editLink' => null,
    'deleteEmit' => null,
])
<div
    class="flex space-x-1">
    <x-wireui:button dark icon="exclamation-circle" xs type="button" wire:click="$dispatch('openModal', { component: 'issues.create-issues-modal', arguments: {model: {{  $id }}}})" title="{{ __('Issues') }}">
        <span class="hidden md:inline-block">
            {{ __('Issues') }}
        </span>
    </x-wireui:button>

    @if ($editLink)
        <x-wireui:button primary href="{{ $editLink }}" xs icon="pencil" wire:navigate title="{{ __('Edit') }}">
        </x-wireui:button>
    @endif

    @if($deleteEmit)
        <x-wireui:button black wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $id }}, emit: '{{ $deleteEmit }}'} })" type="button" xs icon="trash" title="{{ __('Destroy') }}">
        </x-wireui:button>
    @endif
</div>
