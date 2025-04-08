<div
    class="relative flex justify-between gap-x-6 px-4 py-5 bg-gray-50 hover:bg-gray-100 sm:px-6">
    <div class="flex min-w-0 gap-x-4">
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

    <div class="flex shrink-0 items-center gap-y-1 flex-col text-xs text-center justify-center">

        @if($product->stock_color == 'red')
            <span class="flex flex-col justify-center">
                <span>
                    STOCK REQUERIDO: {{ abs((int)$product->AVERAGE_SALES) }}
                </span>
                REQUIERE {{ abs($product->AVERAGE_SALES_DIFFERENCE) }} MÁS
            </span>
        @elseif($product->stock_color == 'yellow')
            <span class="flex flex-col justify-center">
                <span>
                    STOCK REQUERIDO: {{ abs((int)$product->AVERAGE_SALES) }}
                </span>
                STOCK EN EL LÍNITE
            </span>
        @else
            <span class="flex flex-col justify-center">STOCK SUFICIENTE</span>
        @endif
    </div>

    <div class="flex shrink-0 items-center gap-x-4">
        <div class="hidden sm:flex sm:flex-col sm:items-end text-gray-900">
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
                    <span>{{ $product->stock }}</span>
                </div>
                <span>
                    {{ __('Stock') }}
                </span>
            </div>
        </div>
        <div>
            <a href="{{ $product->route_edit }}" wire:navigate>
                <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</div>