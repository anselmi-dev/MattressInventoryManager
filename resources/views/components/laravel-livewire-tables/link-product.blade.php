@props(['value' => null, 'type' => '', 'link' => null])

@if ($value)    
    <a href="{{ $link }}" class="text-app-default | flex items-center gap-1" wire:navigate>
        @switch($type)
            @case('cover')
                <x-icons.cover class="h-4"/>
                @break
            @case('base')
                <x-icons.base class="h-4"/>
                @break
            @case('top')
                <x-icons.top class="h-4"/>
                @break
            @default
        @endswitch
        <span>{{ $value }}</span>
    </a>
@else
    <span class="text-red-500 gap-1">
        <span>N/D</span>
    </span>
@endif