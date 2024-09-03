<ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 rounded">
    @foreach($collection as $item)
        <li>
            <div
                class="relative grid grid-cols-2 md:grid-cols-3 | px-4 py-5 hover:bg-gray-50/100">
                <div class="flex items-center min-w-0 gap-x-2">
                    <div
                        class="p-1 rounded-full w-10 h-10 min-w-10 min-h-10 bg-gray-300 flex items-center justify-center text-white">
                        @switch($item->type)
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
                                {{ $item->code }}
                            </span>
                        </div>
                        <p class="text-sm font-semibold leading-1 text-gray-900">
                            <span>
                                {{ $item->name }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="hidden md:flex shrink-0 items-center gap-y-1 flex-col text-xs text-center justify-center">
                    @if($item->stock_color == 'red')
                        <span class="flex flex-col justify-center">
                            <span>
                                STOCK REQUERIDO: {{ abs((int)$item->average_sales_quantity) }}
                            </span>
                            REQUIERE {{ abs($item->average_sales_difference) }} MÁS
                        </span>
                    @elseif($item->stock_color == 'yellow')
                        <span class="flex flex-col justify-center">
                            <span>
                                STOCK REQUERIDO: {{ abs((int)$item->average_sales_quantity) }}
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
                            <div class="flex items-center gap-x-1.5">
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
                        class="flex items-center justify-center bg-gray-100 rounded">
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
