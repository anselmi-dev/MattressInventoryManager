<x-page.container>
    <x-page.heading title="{{ __('Combinations') }} #{{ $model->code }}" breadcrumbs="parts.show" :model="$model">
        <x-slot name="actions">
            <div class="flex gap-1">
                <x-wireui:button primary href="{{ $model->route_edit }}">
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

        <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
            <dl class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
              <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 ">
                  <dt class="text-sm font-medium leading-6 text-gray-500">Ventas en los últimos {{ settings()->get('stock:days', 10) }} días</dt>
                  {{-- <dd class="text-xs font-medium text-gray-700"</dd> --}}
                  <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $this->averageSales->TOTAL_SALES }}</dd>
                </div>
              <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 sm:border-l">
                  <dt class="text-sm font-medium leading-6 text-gray-500">Promedio por día</dt>
                  {{-- <dd class="text-xs font-medium text-rose-600"></dd> --}}
                  <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ round($this->averageSales->AVERAGE_SALES_PER_DAY, 2) }}</dd>
                </div>
              <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 lg:border-l">
                  <dt class="text-sm font-medium leading-6 text-gray-500">
                    <span>Stock requerido en los próximos {{ settings()->get('stock:days', 10) }} días</span>
                  </dt>
                  {{-- <dd class="text-xs font-medium text-gray-700"</dd> --}}
                  <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $this->averageSales->AVERAGE_SALES }}</dd>
                </div>
              <div class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 sm:border-l">
                  <dt class="text-sm font-medium leading-6 text-gray-500">Unidades faltantes para cubrir las ventas en los próximos {{ settings()->get('stock:days', 10) }} días</dt>
                  {{-- <dd class="text-xs font-medium text-rose-600"></dd> --}}
                  <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ $this->averageSales->AVERAGE_SALES_DIFFERENCE < 0 ? abs($this->averageSales->AVERAGE_SALES_DIFFERENCE) : 0 }}</dd>
            </div>
            </dl>
        </div>
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
