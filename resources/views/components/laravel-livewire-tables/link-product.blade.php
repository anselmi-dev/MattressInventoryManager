@props(['value' => null, 'type' => '', 'link' => null])

@if ($value)    
    <a href="{{ $link }}" class="text-app-default | flex items-center gap-1" wire:navigate>
        @switch($type)
            @case('top')
                <x-icons.top class="h-6"/>
                @break
            @case('combination')
                <x-icons.mattresss class="h-6"/>
                @break
            @case('cover')
                <x-icons.cover class="h-6"/>
                @break
            @case('base')
                <x-icons.base class="h-6"/>
                @break
            @case('pillow')
                <x-icons.pillow class="h-6"/>
                @break
            @case('bed-sheet')
                <x-icons.bed-sheet class="h-6"/>
                @break
            @default
                <x-icons.other class="h-6"/>
        @endswitch
        <span>{{ $value }}</span>
    </a>
@else
    <span class="text-red-500 gap-1">
        <span>N/D</span>
    </span>
@endif