<div
    class="relative grid grid-cols-2 md:grid-cols-3 | px-4 py-5 hover:bg-gray-50/100">
    <div class="flex items-center min-w-0 gap-x-2">
        <div class="min-w-0 flex-auto">
            <div class="text-sm flex flex-row">
                {{ __('Cantidad') }}: {{ $sale->quantity }}
            </div>
            <p class="text-gray-900 font-semibold leading-1">
                <span>
                    {{ $sale->description }}
                </span>
            </p>
        </div>
    </div>

    <div class="hidden md:flex shrink-0 items-center gap-y-1 flex-col text-xs text-center justify-center">
        <div class="flex flex-col sm:items-end text-gray-900 uppercase">
            <span class="hidden md:block">
                {{ __('Status') }}
            </span>
            <div class="flex items-center gap-x-1.5">
                {{ __($sale->status) }}
            </div>
        </div>
    </div>

    <div class="relative flex justify-between gap-x-2">
        <div class="flex shrink-0 items-center gap-x-2 flex-1 justify-end">
            <div class="flex flex-col sm:items-end text-gray-900 text-base">
                <span class="hidden md:block">
                    {{ __('Created at') }}
                </span>
                <div class="flex items-center gap-x-1.5">
                    {{ $sale->created_at }}
                </div>
            </div>
        </div>
    </div>
</div>