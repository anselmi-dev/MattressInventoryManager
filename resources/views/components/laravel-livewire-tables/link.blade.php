@props(['value' => null,'link' => null])

@if ($value)    
    <a href="{{ $link }}" class="text-app-default | flex items-center gap-1" wire:navigate>
        <span>{{ $value }}</span>
    </a>
@else
    -
@endif