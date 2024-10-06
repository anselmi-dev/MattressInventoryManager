<div
    class="relative grid grid-cols-3 | px-4 py-4 hover:bg-gray-50/100">
    <div class="flex items-center min-w-0 gap-x-2">
        <div
            class="p-1 rounded w-10 h-10 min-w-10 min-h-10 bg-gray-300 flex items-center justify-center text-gray-800">
            <x-icons.sale class="h-5" />
        </div>
        <div class="min-w-0 flex-auto">
            <p class="text-gray-900 font-semibold leading-1">
                <span>
                    #{{ $sale->CODFAC }}
                </span>
            </p>
            <p class="text-gray-900 leading-1 text-sm">
                <span>
                    € {{ $sale->TOTFAC }}
                </span>
            </p>

        </div>
    </div>

    <div class="flex shrink-0 items-center gap-y-1 flex-col text-xs text-center justify-center">
        <div class="flex flex-col sm:items-end text-gray-900 uppercase text-base | bg-gray-100 rounded px-1">
            <div class="text-sm flex flex-row items-center">
                {{ $sale->quantity }} <x-wireui:icon name="shopping-cart" class="h-4"/>
                <span class="hidden md:inline-block">
                    {{ __('Products') }}
                </span>
            </div>
        </div>
    </div>

    <div class="relative flex justify-between gap-x-2">
        <div class="flex shrink-0 items-center gap-x-2 flex-1 justify-end">
            <div class="flex flex-col sm:items-end text-gray-900 text-sm gap-0.5">
                
                <x-sales.status :status="$sale->status"/>
                    
                <div class="flex items-center gap-x-1.5">
                    {{ $sale->created_at->format('Y-m-d') }}
                </div>
            </div>
        </div>
        <a
            href="{{ route('sales.show', ['model' => $sale->id]) }}"
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