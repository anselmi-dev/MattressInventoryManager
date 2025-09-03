<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $stockStatuses = $this->getStockStatuses();
        @endphp
        <div class="fi-ta-header-ctn pb-4">
            <div class="fi-ta-header-toolbar">
                <div class="fi-ta-actions fi-align-start fi-wrapped">
                    <span
                        class="fi-color fi-color-primary fi-text-color-700 dark:fi-text-color-400 fi-link fi-size-md  fi-ac-link-action">
                        Listado de productos con stock bajo ( {{ $stockStatuses->count() }} productos )
                    </span>
                </div>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-100 overflow-auto max-h-[300px]">
            @forelse ($stockStatuses as $item)
                <li>
                    <div class="relative grid grid-cols-2 md:grid-cols-3 | px-4 py-3 hover:bg-gray-50">
                        <div class="flex items-center min-w-0 gap-x-2">
                            <div
                                class="p-1 rounded-full w-10 h-10 min-w-10 min-h-10 bg-gray-300 flex items-center justify-center text-gray-800">
                                <svg class="h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"
                                    fill="currentColor">
                                    <defs></defs>
                                    <title>product</title>
                                    <rect x="8" y="18" width="6" height="2"></rect>
                                    <rect x="8" y="22" width="10" height="2"></rect>
                                    <path
                                        d="M26,4H6A2.0025,2.0025,0,0,0,4,6V26a2.0025,2.0025,0,0,0,2,2H26a2.0025,2.0025,0,0,0,2-2V6A2.0025,2.0025,0,0,0,26,4ZM18,6v4H14V6ZM6,26V6h6v6h8V6h6l.0012,20Z">
                                    </path>
                                    <rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;"
                                        class="cls-1" width="32" height="32" style="fill:none"></rect>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-auto">
                                <div class="text-xs leading-none text-gray-500 | flex flex-wrap gap-1.5">
                                    <span>
                                        {{ $item->code }}
                                    </span>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">
                                    <span class="line-clamp-2">
                                        {{ $item->name }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div
                            class="hidden md:flex shrink-0 items-center gap-y-1 flex-col text-xs text-center justify-center">
                            <span class="flex flex-col justify-center">
                                <span>
                                    STOCK REQUERIDO: {{ abs((int) $item->AVERAGE_SALES) }}
                                </span>
                            </span>
                        </div>

                        <div class="relative flex justify-between gap-x-2">
                            <div class="flex shrink-0 items-center gap-x-2 flex-1 justify-end">
                                <div class="flex flex-col sm:items-end text-gray-900">
                                    <span class="hidden md:block uppercase">
                                        {{ $item->type }}
                                    </span>
                                    <div class="flex items-center gap-1 w-fit relative bg-red-100 rounded-full px-2"
                                        x-data="{ tooltip: 'El stock está considerablemente por debajo del nivel promedio requerido.' }" x-tooltip="tooltip">
                                        <span class="relative flex h-3 w-3">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-600 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                                        </span>
                                        <div class="flex flex-col">
                                            <span>{{ $item->STOCK_LOTES }}</span>
                                        </div>
                                        <span>
                                            Stock
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-3">
                    <div class="flex items-center min-w-0 gap-x-2">
                        <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold text-gray-900">
                                <span class="line-clamp-2">
                                    No se encontraron productos con stock bajo
                                </span>
                            </p>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>
    </x-filament::section>
</x-filament-widgets::widget>
