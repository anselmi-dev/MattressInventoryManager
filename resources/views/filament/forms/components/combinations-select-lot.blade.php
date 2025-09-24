<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div class="space-y-4" x-data="{ state: $wire.$entangle(@js($getStatePath())) }" {{ $getExtraAttributeBag() }}>
        @if ($getLot())
            @forelse ($getRelatedLots() as $item)
                <fieldset aria-label="Parte del lote">
                    <div class="space-y-2 rounded-lg border border-gray-300 bg-white px-6 py-4 ">
                        <div
                            class="group relative block has-checked:outline-2 has-checked:-outline-offset-2 has-checked:outline-indigo-600 has-focus-visible:outline-3 has-focus-visible:-outline-offset-1 sm:flex sm:justify-between dark:border-white/10 dark:bg-gray-800/50 dark:has-checked:outline-indigo-500">
                            <span class="flex items-center">
                                <span class="flex flex-col text-sm">
                                    <span
                                        class="font-medium text-gray-900 dark:text-white">{{ $item->relatedLot->name }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">
                                        <span class="block sm:inline"> {{ $item->relatedLot->reference }}</span>
                                        <span aria-hidden="true" class="hidden sm:mx-1 sm:inline">&middot;</span>
                                        <span class="block sm:inline">{{ $item->relatedLot->product->name }}</span>
                                    </span>
                                </span>
                            </span>

                            <span class="mt-2 flex text-sm sm:mt-0 sm:ml-4 sm:flex-col sm:text-right">
                                <span
                                    class="font-medium text-gray-900 dark:text-white">{{ $item->relatedLot->quantity }}</span>
                                <span class="ml-1 text-gray-500 sm:ml-0 dark:text-gray-400">/Stock</span>
                            </span>
                        </div>

                        @if (!$item->relatedLot->product->factusolProduct)
                            <x-alerts.product-factusol />
                        @endif
                    </div>
                </fieldset>
            @empty
                <x-alerts.warning>
                    El colchón no tiene lotes disponibles.
                </x-alerts.warning>
            @endforelse
        @endif
    </div>
</x-dynamic-component>
