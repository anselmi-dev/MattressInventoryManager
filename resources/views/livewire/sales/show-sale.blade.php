<x-page.container>
    <x-page.heading title="{{ __('Sale') }} #{{ $model->id }}" breadcrumbs="parts.show" :model="$model">
        <x-slot name="actions">
            <div class="flex gap-1">
                <p class="text-sm text-gray-600">{{ __('Order placed') }} <time datetime="{{ $model->FECFAC->format('Y-m-d') }}" class="font-medium text-gray-900">{{ $model->FECFAC->format('Y-m-d') }}</time></p>
            </div>
        </x-slot>
    </x-page.heading>
            
    <x-page.content>
        <!-- Products -->
        <dl class="divide-y divide-gray-200 text-sm lg:col-span-5 lg:mt-0">
            @foreach ($model->product_sales as $product_sale)
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
        </dl>
    </x-page.content>
    
    <x-page.content>
        <!-- Billing -->
        <section aria-labelledby="summary-heading">
            <div class="sm:rounded-lg lg:grid lg:grid-cols-12">
                <dl class="grid grid-cols-2 gap-6 text-sm sm:grid-cols-2 md:gap-x-8 lg:col-span-7">
                    <div>
                        <dt class="font-medium text-gray-900">
                            {{ __('Customer Information') }}
                        </dt>
                        <dd class="mt-3 text-gray-500">
                            <span class="block">
                                {{ $model->CLIFAC }}
                            </span>
                            <span class="block">
                                {{ $model->CNOFAC }}
                            </span>
                            <span class="block">
                                {{ $model->CEMFAC }}
                            </span>
                        </dd>
                    </div>
                </dl>
        
                <dl class="mt-4 divide-y divide-gray-200 text-sm lg:col-span-5 lg:mt-0">
                    <div class="flex items-center justify-between pb-2">
                        <dt class="text-gray-600">
                            {{ __('Subtotal') }}
                        </dt>
                        <dd class="font-medium text-gray-900">
                            € {{ $model->NET1FAC }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <dt class="text-gray-600">
                            {{ __('Additional Fee') }}
                        </dt>
                        <dd class="font-medium text-gray-900">
                            € {{ $model->IREC1FAC }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <dt class="text-gray-600">
                            {{ __('Tax') }}
                        </dt>
                        <dd class="font-medium text-gray-900">
                            € {{ $model->IIVA1FAC }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <dt class="font-medium text-gray-900">
                            {{ __('Order total') }}
                        </dt>
                        <dd class="font-medium text-indigo-600">
                            € {{ $model->TOTFAC }}
                        </dd>
                    </div>
                </dl>
            </div>
        </section>
    </x-page.content>
</x-page.container>
