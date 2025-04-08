<div class="flex flex-col">
    <div class="flex justify-between items-center space-x-1 p-2 rounded-t shadow-sm ring-1 ring-gray-900/5 bg-white">
        <h2 class="text-base md:text-lg font-semibold | flex items-center space-x-1">
            <x-wireui:icon name="archive-box" class="h-5"/>
            <span>{{ __('Stocks') }}</span>
        </h2>
        <a href="{{ route('products.index') }}" wire:navigate class="flex space-x-1 justify-center items-center | font-semibold px-2 rounded-full |  transition-all text-app-primary dark:text-app-hover">
            {{ __('See more') }}
            <x-wireui:icon name="arrow-right" class="h-4"/>
        </a>
    </div>

    <ul role="list" class="divide-y divide-gray-100 overflow-hidden shadow-sm ring-1 ring-gray-900/5 rounded-b bg-white">
        @foreach($collection as $item)
            <li>
                <div
                    class="relative grid grid-cols-2 md:grid-cols-3 | px-4 py-3 hover:bg-gray-50">
                    <div class="flex items-center min-w-0 gap-x-2">
                        <div
                            class="p-1 rounded-full w-10 h-10 min-w-10 min-h-10 bg-gray-300 flex items-center justify-center text-gray-800">
                            @switch($item->type)
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
                                    {{ $item->code }}
                                </span>
                            </div>
                            <p class="text-sm font-semibold leading-1 text-gray-900">
                                <span class="line-clamp-2">
                                    {{ $item->name }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="hidden md:flex shrink-0 items-center gap-y-1 flex-col text-xs text-center justify-center">
                        @if($item->stock_color == 'red')
                            <span class="flex flex-col justify-center">
                                <span>
                                    STOCK REQUERIDO: {{ abs((int)$item->AVERAGE_SALES) }}
                                </span>
                                REQUIERE {{ abs($item->AVERAGE_SALES_DIFFERENCE) }} MÁS
                            </span>
                        @elseif($item->stock_color == 'yellow')
                            <span class="flex flex-col justify-center">
                                <span>
                                    STOCK REQUERIDO: {{ abs((int)$item->AVERAGE_SALES) }}
                                </span>
                                STOCK EN EL LÍNITE
                            </span>
                        @else
                            <span class="flex flex-col justify-center">STOCK SUFICIENTE</span>
                        @endif
                    </div>

                    <div class="relative flex justify-between gap-x-2">
                        <div class="flex shrink-0 items-center gap-x-2 flex-1 justify-end">
                            <div class="flex flex-col sm:items-end text-gray-900">
                                <span class="hidden md:block uppercase">
                                    {{ __($item->type) }}
                                </span>
                                <div class="flex items-center gap-1 w-fit relative bg-{{ $item->stock_color }}-100 rounded-full px-2"
                                    x-data="{ tooltip: '{{ __('average-stock:' . $item->stock_color) }}' }"
                                    x-tooltip="tooltip">
                                    <span class="relative flex h-3 w-3">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $item->stock_color }}-600 opacity-75"></span>
                                        <span
                                            class="relative inline-flex rounded-full h-3 w-3 bg-{{ $item->stock_color }}-600"></span>
                                    </span>
                                    <div class="flex flex-col">
                                        <span>{{ $item->stock }}</span>
                                    </div>
                                    <span>
                                        {{ __('Stock') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <a
                            href="{{ $item->route_show }}"
                            wire:navigate
                            class="flex items-center justify-center bg-gray-100 rounded hover:bg-app-100 transition-all">
                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
