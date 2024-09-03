<div class="flex flex-col space-y-3 p-4">
    <div class="w-full text-2xl">
        Generar nuevo pedido
    </div>
    
    <x-form.container-left>
        <x-form.section-left>
            <div class="divide-y divide-gray-300 overflow-hidden w-full">
                @forelse ($products as $key => $product)
                    <x-orders.card-product-order :product="$product" :quantity="$order_product->quantity">
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
                        <span>No hay productos en la orden</span>
                    </div>
                @endforelse
            </div>

            <div x-data="{show: false}" class="my-2 py-2">

                <div class="relative mt-2">
                    <div class="flex items-start justify-between gap-2">
                        <x-wireui:select
                            wire:model.defer="new.part"
                            placeholder="Buscar parte"
                            :async-data="route('api.parts.index')"
                            option-label="code"
                            option-value="id"
                            hide-empty-message
                        />
    
                        <x-wireui:button type="button" wire:click="addPart" icon="plus">
                            Agregar
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
                {{ __('Crear solicitud') }}
            </x-wireui:button>
        </x-slot>
    </x-form.container-left>
</div>
