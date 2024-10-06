<span class="flex items-center gap-1">
    @switch($value)
        @case(0)
            <x-wireui:icon name="clock" class="h-4 text-yellow-600" />
            <span>
                {{ __('pending') }}
            </span>
            @break
        @case(1)
            <x-wireui:icon name="clock" class="h-4 text-yellow-600" />
            <span>
                {{ __('pending') }}
            </span>>
            @break
        @case(2)
            <x-wireui:icon name="check-circle" class="h-4 text-app-default"/>
            <span>
                {{ __('processed') }}
            </span>
            @break
        @case(3)
            <x-wireui:icon name="x-circle" class="h-4 text-red-600"/>
            <span>
                {{ __('error') }}
            </span>
            @break
        @default
            
    @endswitch
</span>