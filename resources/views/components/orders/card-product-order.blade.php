<div class="flex flex-col gap-1 bg-gray-50 hover:bg-gray-100  px-2 py-2 sm:px-3 gap-y-3">
    <div
        class="relative flex justify-between items-center gap-x-3">
        <div class="flex min-w-0 gap-x-2">
            <div
                title="{{ __($product->type) }}"
                class="p-1 rounded-full min-w-10 h-10 bg-gray-300 flex items-center justify-center text-gray-800">
                @switch($product->type)
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
            </div>

            <div class="min-w-0 flex-auto">
                <div class="text-xs leading-none text-gray-500 | flex flex-wrap gap-1.5">
                    <span>
                        {{ $product->code }}
                    </span>
                </div>
                <p class="text-sm font-semibold leading-1 text-gray-900">
                    <span>
                        {{ $product->name }}
                    </span>
                </p>
            </div>
        </div>

        <div class="flex flex-col justify-center shrink-0 items-end gap-1.5">
            <div class="flex items-center gap-x-1.5">
                <span class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $product->stock_color }}-600 opacity-75"></span>
                    <span
                        class="relative inline-flex rounded-full h-3 w-3 bg-{{ $product->stock_color }}-600"></span>
                </span>
                <div class="flex flex-col items-end gap-0.5 text-sm">
                    <span class="flex items-center space-x-1 | bg-gray-300 rounded-full px-1 w-fit">
                        <span>{{ __('Stock') }}: </span> <span>{{ $product->stock }}</span>
                    </span>
                    @if (@isset($quantity))
                        <span class="flex items-center space-x-1 | bg-gray-300 rounded-full px-1 w-fit">
                            <span>Mínimo</span>
                            <x-wireui:icon name="shopping-cart" class="h-4"/>
                            <span>{{ $quantity }}</span>

                            @if (isset($return) && $return)
                                <span>- {{ $return }}</span>
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{ $slot }}
</div>