<span class="flex items-center gap-1">
    @switch($value)
        @case('pending')
            <x-wireui:icon name="clock" class="h-4 text-yellow-600" />
            <span>
                {{ __('pending') }}
            </span>
            @break
        @case('processed')
            <x-wireui:icon name="check-circle" class="h-4 text-app-default"/>
            <span>
                {{ __('processed') }}
            </span>
            @break
        @case('error')
            <x-wireui:icon name="x-circle" class="h-4 text-red-600"/>
            <span>
                {{ __('error') }}
            </span>
            @break
        @default
            
    @endswitch
</span>