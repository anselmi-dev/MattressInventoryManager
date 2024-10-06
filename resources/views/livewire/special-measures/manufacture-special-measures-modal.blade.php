<div class="w-full px-4 pb-4 pt-5 sm:p-6">
    <div class="flex flex-col relative space-y-5"
        x-data="{
            showSearch: false,
            showFilters: false
        }">
        <x-loading-livewire/>

        <x-page.heading>
            <x-slot name="title">
                <span class="block">{{ __('Manufacture Special Measures') }}</span>
            </x-slot>
            <x-slot name="description">
                {{ __("To manufacture the combination, ensure that the minimum stock of each part is available, as you cannot create more units than what is recorded in the system.") }}
            </x-slot>
        </x-page.heading>
    
        <x-form.container-left>

            <x-form.group-full>
                <ul class="flex flex-col mt-4 space-y-1">
                    <li class="flex items-center gap-1 flex-wrap text-sm pt-2">
                        <div class="text-truncate flex-1">
                            @if ($productSale->product)    
                                <a href="{{ $productSale->product->route_show }}" wire:navigate class="text-app-default font-semibold">
                                    {{ $productSale->ARTLFA }}
                                </a>
                            @else
                                <span class="font-semibold">{{ $productSale->ARTLFA }}</span>
                            @endif

                            <p>{{ $productSale->DESLFA }}</p>
                        </div>

                        <div class="flex flex-col whitespace-nowrap border-l-2 pl-2">
                            <span class="font-semibold">
                                {{ __('Dimension') }}
                            </span>
                            <div>
                                <span>{{ $width }}</span>X<span>{{ $height }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col whitespace-nowrap border-l-2 pl-2">
                            <span class="font-semibold">
                                {{ __('Quantity') }}
                            </span>
                            {{ $productSale->CANLFA }}
                        </div>
                    </li>
                    {{--
                        <li>
                            <div x-data="{show: false}" class="flex flex-col w-full px-2 pb-2 rounded">

                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-300"></div>
                                    </div>
                                    <div class="relative flex items-center justify-end">
                                        <button @click="show = !show" type="button" class="inline-flex items-center gap-x-1.5 bg-transparent text-app-default px-3 text-base font-bold bg-white pl-1">
                                            {{ __('Show invoice') }}
                                        </button>
                                    </div>
                                </div>
                                    
                                <div x-show="show" class="bg-gray-100/50 p-4 rounded flex flex-col mt-2">
                                    <section class="divide-y divide-gray-200 text-sm lg:col-span-5 lg:mt-0">
                                        @foreach ($productSale->sale->product_sales as $product_sale)
                                            <div class="grid grid-cols-2 lg:grid-cols-4 justify-between gap-2 pb-2 py-2">
                                                <div class="flex-1 col-span-1 lg:col-span-2">
                                                    <div>
                                                        @if ($product_sale->product)    
                                                            <a href="{{ $product_sale->product->route_show }}" wire:navigate class="text-app-default font-semibold">
                                                                {{ $product_sale->ARTLFA }}
                                                            </a>
                                                        @else
                                                            <span class="font-semibold">{{ $product_sale->ARTLFA }}</span>
                                                        @endif
                                                    </div>
                                                    <p>{{ $product_sale->DESLFA }}</p>
                                                </div>
                                                <div class="text-right hidden lg:flex items-center justify-center">
                                                    {{ __('Quantity') }} {{ $product_sale->CANLFA }}
                                                </div>
                                                <div class="text-right flex justify-between lg:justify-end flex-col lg:flex-row lg:items-center">
                                                    <p class="block lg:hidden">
                                                        {{ __('Quantity') }} {{ $product_sale->CANLFA }}
                                                    </p>
                            
                                                    <span>€ {{ $product_sale->TOTLFA }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </section>
                                    
                                    <section aria-labelledby="summary-heading" class="mt-2 border-t border-gray-400 pt-2">
                                        <div class="sm:rounded-lg lg:grid lg:grid-cols-12">
                                            <dl class="grid grid-cols-2 gap-6 text-sm sm:grid-cols-2 md:gap-x-8 lg:col-span-7">
                                            </dl>
                                    
                                            <dl class="mt-4 divide-y divide-gray-200 text-sm lg:col-span-5 lg:mt-0">
                                                <div class="flex items-center justify-between pb-2">
                                                    <dt class="text-gray-600">
                                                        {{ __('Subtotal') }}
                                                    </dt>
                                                    <dd class="font-medium text-gray-900">
                                                        € {{ $productSale->sale->NET1FAC }}
                                                    </dd>
                                                </div>
                                                <div class="flex items-center justify-between py-2">
                                                    <dt class="text-gray-600">
                                                        {{ __('Additional Fee') }}
                                                    </dt>
                                                    <dd class="font-medium text-gray-900">
                                                        € {{ $productSale->sale->IREC1FAC }}
                                                    </dd>
                                                </div>
                                                <div class="flex items-center justify-between py-2">
                                                    <dt class="text-gray-600">
                                                        {{ __('Tax') }}
                                                    </dt>
                                                    <dd class="font-medium text-gray-900">
                                                        € {{ $productSale->sale->IIVA1FAC }}
                                                    </dd>
                                                </div>
                                                <div class="flex items-center justify-between pt-2">
                                                    <dt class="font-medium text-gray-900">
                                                        {{ __('Order total') }}
                                                    </dt>
                                                    <dd class="font-medium text-indigo-600">
                                                        € {{ $productSale->sale->TOTFAC }}
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </li>
                    --}}
                </ul>
            </x-form.group-full>

            @if ($productSale->specialMeasurement)
                <x-form.container-left>
                    <x-alerts.warning class="mb-2">
                        Ya se fabricó la medida especial el {{ $productSale->specialMeasurement->created_at->format('d-m-Y') }}.
                    </x-alerts.warning>
                </x-form.container-left>
            @else
                @if ($currentProduct)
                    <x-form.group-full>
                        <div class="flex flex-col w-full">
                            <x-products.card-product :product="$currentProduct">
                                <x-slot name="action">
                                    <div></div>
                                </x-slot>
                            </x-products.card-product>

                            <div class="flex items-center justify-end px-2 pt-1 mb-2">
                                <button type="button" wire:click="removeProduct()" class="font-bold text-app-default">
                                    Seleccionar otro producto
                                </button>
                            </div>
                        </div>
                    </x-form.group-full>

                    <x-form.group-full>
                        @if ((int)$this->productSale->CANLFA > (int)$currentProduct->stock)                
                            <x-form.container-left>
                                <x-alerts.warning class="mb-2">
                                    El Stock del producto es inferior al de la venta. Aumente el stock del producto o seleccione otro.
                                </x-alerts.warning>
                            </x-form.container-left>
                        @endif
                    </x-form.group-full>
                @else
                    <x-form.group-full >
                        <div class="divide-y divide-gray-300 overflow-hidden w-full">
                            <div class="font-bold text-xl mb-2 | flex items-center justify-between">
                                <span>Sugerencias para fabricar</span>
                            </div>
        
                            <div class="divide-y divide-gray-300 overflow-hidden w-full">
                                @forelse ($products as $key => $product)
                                    <x-products.card-product :product="$product">
                                        <x-slot name="action">
                                            <button
                                                type="button"
                                                wire:click="selectProduct({{ $product->id }})"
                                                class="flex items-center justify-center bg-app-200 hover:bg-app-hover rounded pointer text-gray-900 hover:text-white">
                                                <svg class="h-5 w-5 flex-none"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                    </x-products.card-product>
                                @empty
                                    <div class="bg-gray-100 rounded | flex items-center justify-center p-3">
                                        <span>
                                            {{ __("No se encontró productos para la medida") }}
                                        </span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </x-form.group-full>
                    
                    <x-form.group-full>
                        <div class="rounded w-full" x-data="{showFilters: false}">
                            <div class="flex flex-col space-y-1">
                                <div class="font-bold text-xl mb-2 | flex items-center justify-between">
                                    <span>Buscar parte para fabricar</span>
                                    <button type="button"  @click="showFilters = !showFilters" class="font-bold text-app-primary text-base border border-app-primary px-2 rounded">
                                        <span>Filtros</span>
                                    </button>
                                </div>
                                <div x-show="showFilters"
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
                                        wire:model.live="filters.type"
                                    />
                                    <x-wireui:select
                                        :placeholder="__('Select one Dimension')"
                                        :options="$this->dimensions"
                                        option-label="label"
                                        option-value="value"
                                        wire:model.live="filters.dimension_id"
                                    />
                                </div>
                            </div>
                            <div class="relative mt-2">
                                <div class="flex items-start justify-between gap-2">
                                    <x-wireui:select
                                        wire:model.defer="filters.product_id"
                                        placeholder="Buscar parte"
                                        :async-data="$this->path_async_data"
                                        option-label="code"
                                        option-value="id"
                                        option-description="name"
                                        hide-empty-message
                                    />
                
                                    <x-wireui:button type="button" wire:click="addProductFilters" icon="plus">
                                        {{ __('Select') }}
                                    </x-wireui:button>
                                </div>
                            </div>
                        </div>
                    </x-form.group-full>
                @endif
            @endif

            @if ($errors->any())
                <x-form.group-full>
                    <x-wireui:errors/>
                </x-form.group-full>
            @endif
            
            <x-slot name="actions">
                <x-wireui:button black type="button" wire:click="$dispatch('closeModal')">
                    {{ __('Cancel') }}
                </x-wireui:button>
                
                @if (!$productSale->specialMeasurement)
                    <x-wireui:button right-icon="check" type="button" primary wire:click="submit()">
                        {{ __('Yes, proceed') }}
                    </x-wireui:button>
                @endif
            </x-slot>
        </x-form.container-left>
    </div>
</div>


