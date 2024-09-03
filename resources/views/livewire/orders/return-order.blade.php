<div class="flex flex-col space-y-3 p-4">
    <div class="w-full text-2xl">
        Generar devolución de la orden #{{ $order->id }}
    </div>
    
    <x-form.container-left>
        <x-form.section-left>
            <div class="divide-y divide-gray-300 overflow-hidden w-full">
                @forelse ($products as $key => $product)
                    <x-orders.card-product-order :product="$product" :quantity="$product->order_product_quantity">
                        <div class="flex items-center justify-between gap-1.5">
                            <div class="sm:max-w-[200px]">
                                <x-wireui:number
                                    :placeholder="__('Quantity')"
                                    wire:model="products.{{ $key }}.return"
                                />
                            </div>
                        </div>
                    </x-orders.card-product-order>
                @empty
                    <div class="bg-gray-100 rounded | flex items-center justify-center p-3">
                        <span>No hay productos en la orden</span>
                    </div>
                @endforelse
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
                {{ __('Generar devolución') }}
            </x-wireui:button>
        </x-slot>
    </x-form.container-left>
</div>
