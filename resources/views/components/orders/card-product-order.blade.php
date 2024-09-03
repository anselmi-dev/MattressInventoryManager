<div class="flex flex-col gap-1 bg-gray-50 hover:bg-gray-100  px-2 py-2 sm:px-3 gap-y-3">
    <div
        class="relative flex justify-between items-center gap-x-3">
        <div class="flex min-w-0 gap-x-2">
            <div
                class="p-1 rounded-full w-10 h-10 bg-gray-300 flex items-center justify-center text-white">
                @switch($product->type)
                    @case('top')
                        <x-icons.top class="h-5" />
                        @break
                    @case('combination')
                        <x-icons.mattresss class="h-5" />
                        @break
                    @case('cover')
                        <x-icons.cover class="h-5" />
                        @break
                    @case('base')
                        <x-icons.base class="h-5" />
                        @break
                    @default
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
            <span class="uppercase">
                {{ __($product->type) }}
            </span>
            <div class="flex items-center gap-x-1.5">
                <span class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $product->stock_color }}-600 opacity-75"></span>
                    <span
                        class="relative inline-flex rounded-full h-3 w-3 bg-{{ $product->stock_color }}-600"></span>
                </span>
                <div class="flex flex-col">
                    @if (@isset($quantity))
                    <span class="flex">
                        <span>{{ $quantity }}</span>
                        @if (isset($return) && $return)
                            <span class="ml-1">- {{ $return }}</span>
                        @endif
                    </span>
                    @else
                        <span>{{ $product->stock }}</span>
                    @endif
                </div>
                <span>
                    {{ __('Quantity') }}
                </span>
            </div>
        </div>
    </div>

    {{ $slot }}
</div>