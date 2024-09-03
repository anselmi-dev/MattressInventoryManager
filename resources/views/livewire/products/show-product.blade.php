<x-page.container>
    <x-page.heading title="{{ __('Product') }} #{{ $model->code }}" breadcrumbs="parts.show" :model="$model">
        <x-slot name="actions">
            <div class="flex gap-1">
                <x-wireui:button primary href="{{ route('products.model', ['model' => $model]) }}">
                    {{ __('Edit') }}
                </x-wireui:button>
                <x-wireui:button
                    secondary
                    x-data="{ tooltip: '{{ __('Request more stock of the product by generating a new order.') }}' }"
                    x-tooltip="tooltip"
                    wire:click="$dispatch('openModal', { component: 'orders.generate-order-modal', arguments: {product_ids: {{  $model->id }}}})"
                    type="button">
                    <x-wireui:icon name="plus" class="h-4"/>
                    <span>
                        {{ __('Generate order') }}
                    </span>
                </x-wireui:button>
            </div>
        </x-slot>
    </x-page.heading>
        
    <x-page.content>
        <x-products.card-product :product="$model"/>
    </x-page.content>
    
    <x-page.content>

        <x-loading-livewire/>

        <x-page.heading title="{{ __('Orders') }}" md/>

        <div class="space-y-2 mt-2">
            <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 rounded">
                @forelse ($orders as $order)
                    <li>
                        <x-orders.card-order :order="$order"/>
                    </li>
                @empty
                <ul>
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            {{-- <h3 class="text-base font-semibold leading-6 text-gray-900">
                                Ups!
                            </h3> --}}
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>{{ __('No record was found in the database') }}</p>
                            </div>
                        </div>
                    </div>                          
                </ul>
                @endforelse
            </ul>

            {{ $orders->links() }}
        </div>
    </x-page.content>
    
    <x-page.content>
        
        <x-page.heading title="{{ __('Sales') }}" md/>

        <div class="space-y-2 mt-2">
            <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 rounded">
                @forelse ($sales as $sale)
                    <li>
                        <x-sales.card-sale :sale="$sale"/>
                    </li>
                @empty
                    <ul>
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">
                                    Ups!
                                </h3>
                                <div class="mt-2 max-w-xl text-sm text-gray-500">
                                    <p>{{ __('No record was found in the database') }}</p>
                                </div>
                            </div>
                        </div>                          
                    </ul>
                @endforelse
            </ul>

            {{ $sales->links() }}
        </div>
    </x-page.content>
</x-page.container>
