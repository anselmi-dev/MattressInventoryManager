<div class="flex flex-col space-y-3 p-4">
    <div class="w-full text-2xl | flex items-center space-x-1">
        <x-icons.orders class="h-6"/>
        {{ __('Generate new order') }}
    </div>
    
    <x-form.container-left>
        <x-form.section-left>
            <div class="divide-y divide-gray-300 overflow-hidden w-full">
                @forelse ($products as $key => $product)
                    <x-orders.card-product-order :product="$product" :quantity="$product->quantity">
                        <div class="flex items-center justify-between gap-1.5">
                            <div class="sm:max-w-[200px]">
                                <x-wireui:number
                                    :placeholder="__('Quantity')"
                                    wire:model="products.{{ $key }}.quantity"
                                />
                            </div>

                            <button type="button" primary wire:click="remove({{ $key }})" class="font-semibol text-app-primary">
                                {{ __('Remove') }}
                            </button>
                        </div>
                    </x-orders.card-product-order>
                @empty
                    <div class="bg-gray-100 rounded | flex items-center justify-center p-3">
                        <span>
                            {{ __("There are no products in this order") }}
                        </span>
                    </div>
                @endforelse
            </div>

            <div x-data="{show: false}" class="my-2 py-2 bg-gray-50 p-2 rounded">
                <div class="flex flex-col space-y-1">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex items-center justify-between">
                            <span class="bg-gray-50 pr-3 text-sm font-semibold leading-6 text-gray-900">Buscar</span>
                            <button @click="show= !show" type="button" class="inline-flex items-center gap-x-1.5 rounded-full bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 ">
                                <svg
                                    :class="{ 'rotate-180': show }"
                                    class="-ml-1 -mr-0.5 h-4 w-4 text-gray-400 transition-transform duration-300" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                                </svg>
                                <span>Filtros</span>
                            </button>
                        </div>
                    </div>
                    <div x-show="show"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="p-2 mb-2 | flex gap-1 | rounded bg-gray-300">
                        <x-wireui:select
                            :placeholder="__('Select one Type')"
                            :options="$this->product_types"
                            wire:model.live="new.filters.type"
                        />
                        <x-wireui:select
                            :placeholder="__('Select one Dimension')"
                            :options="$this->dimensions"
                            option-label="label"
                            option-value="value"
                            wire:model.live="new.filters.dimension_id"
                        />
                    </div>
                </div>
                <div class="relative mt-2">
                    <div class="flex items-start justify-between gap-2">
                        <x-wireui:select
                            wire:model.defer="new.part"
                            placeholder="Buscar parte"
                            :async-data="$this->path_async_data"
                            option-label="code"
                            option-value="id"
                            option-description="name"
                            hide-empty-message
                        />
    
                        <x-wireui:button type="button" wire:click="addPart" icon="plus">
                            {{ __('Add') }}
                        </x-wireui:button>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <x-wireui:errors/>
            @endif

        </x-form.section-left>
            
        <x-loading-livewire/>

        <x-slot name="actions">
            <x-wireui:button black type="button" primary wire:click="$dispatch('closeModal')">
                {{ __('Cancel') }}
            </x-wireui:button>

            <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                {{ __('Create request') }}
            </x-wireui:button>
        </x-slot>
    </x-form.container-left>
</div>
