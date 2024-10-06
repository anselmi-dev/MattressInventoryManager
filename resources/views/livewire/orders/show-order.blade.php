<x-page.container>
    <div class="mx-auto w-full">
        {{ Breadcrumbs::render('order.show', $order) }}
    
        <div class="flex items-center justify-between">
            <div class="min-w-0 flex-1">
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('Order #:order_id', ['order_id' => $order->id]) }}
                </h1>
            </div>

            @if ($order->is_processed)
              <div class="flex flex-col justify-center shrink-0 items-end gap-1.5">
                    <x-wireui:button
                        secondary
                        wire:click="$dispatch('openModal', { component: 'orders.return-order', arguments: {order: {{ $order->id }}}})"
                        type="button">
                        <span>
                            {{ __('Devolución') }}
                        </span>
                    </x-wireui:button>
                </div>
            @endif
        </div>
    </div>
        
    <x-page.content>
        <x-loading-livewire/>
        
        <x-form.container-left>
            <x-form.group-full>
                <div>
                    <label class="block font-medium leading-6 text-gray-900">
                       {{ __('Products') }} ({{ $order->order_products->count() }})
                    </label>
                </div>
                <div class="divide-y divide-gray-400">
                    @foreach ($order->order_products as $order_product)
                        <x-orders.card-product-order :product="(object)$order_product->attribute_data" :quantity="$order_product->quantity" :return="$order_product->return">
                        </x-orders.card-product-order>
                    @endforeach
                </div>
            </x-form.group-full>

            <hr>

            @if ($order->is_pending)
                <x-form.group-left :label="__('Email')">
                    <x-slot name="description">
                        {{ __('The request recipient.') }}
                    </x-slot>
                    <div class="w-full">
                        <x-wireui:input
                            :placeholder="__('Email')"
                            type="email"
                            wire:model="order.email"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-full>
                    <div>
                        <label class="block font-medium leading-6 text-gray-900">
                        {{ __('Message') }}
                        </label>
                    </div>
                    <div wire:ignore wire:key='order-message'>
                        <div
                            x-data="{
                                iniEditor (id, variable) {
                                    $(id).summernote({
                                        placeholder: 'Contenido',
                                        tabsize: 2,
                                        height: 300,
                                        dialogsInBody: true,
                                        toolbar: [
                                            ['view', ['fullscreen', 'codeview']],
                                            ['insert', ['link']],
                                        ],
                                        callbacks: {
                                            onChange: function(contents, $editable) {
                                                var div = $('<div />');
                        
                                                div.append(contents);
                        
                                                div.find('*').removeAttr('style');
                        
                                                $wire.set(variable, div.html(), false);
                                            }
                                        }
                                    });
                        
                                    $(id).summernote('code', $wire.get(variable))
                        
                                    Livewire.on('clear-editor', () => {
                                        $(id).summernote('code', '')
                                    });
                                }
                            }"
                            x-init="
                                iniEditor('#order-message', 'order.message')
                            "
                            id="order-message">
                        </div>
                    </div>
                </x-form.group-full>
            @else
                <div>
                    <div>
                        <label class="block font-medium leading-6 text-gray-900">
                            Mensaje enviado a {{ $order->email }}
                        </label>
                    </div>
                    <div class="p-2 rounded bg-gray-100">
                        {!! $order->message !!}
                    </div>
                </div>
            @endif

            <x-form.section-left>
                @if ($order->is_pending)
                    <x-alerts.warning class="mb-2">
                        {{ __('order:next:shipped', ['email' => $order->email]) }}
                    </x-alerts.warning>
                @elseif ($order->is_shipped)
                    <x-alerts.warning class="mb-2">
                        {{ __('order:next:processed') }}
                    </x-alerts.warning>
                @endif

                <x-wireui:errors/>
            </x-form.section-left>

            <x-slot name="actions">
                <x-wireui:button black href="{{ route('orders.index') }}">
                    {{ __('Back') }}
                </x-wireui:button>

                @if (!$order->trashed())
                    @if ($order->is_pending || $order->is_shipped)
                        <div x-data="{open: false}" class="inline-flex rounded-md shadow-sm">
                            @if ($order->is_pending)
                                <button
                                    wire:click="confirm_shipment()"
                                    type="button"
                                    class="cursor-init relative inline-flex items-center rounded-l-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10_ uppercase">
                                    {{ __('confirm_shipment') }}
                                </button>
                            @else
                                <button
                                    wire:click="confirm_delivery()"
                                    type="button"
                                    class="cursor-init relative inline-flex items-center rounded-l-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10_ uppercase">
                                    {{ __('confirm_delivery') }}
                                </button>
                            @endif

                            <div class="relative -ml-px block">
                                <button @click="open = !open" type="button" class="relative inline-flex items-center rounded-r-md bg-white px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10" id="option-menu-button" aria-expanded="true" aria-haspopup="true">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            
                                <div x-show="open"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 -mr-1 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state."
                                    role="menu"
                                    aria-orientation="vertical"
                                    aria-labelledby="option-menu-button"
                                    tabindex="-1"
                                    @keydown.tab="open = false"
                                    @keydown.enter.prevent="open = false;"
                                    @keyup.space.prevent="open = false;"
                                    style="display: none;">
                                    <div class="py-1" role="none">    
                                        <button type="button" wire:click="confirm_canceld()" class="block px-4 py-2 text-sm text-gray-700">
                                            {{ __('cancel_order') }}
                                        </button>
                                        <button
                                            {{-- x-data="{ tooltip: '{{ __('Destroy') }}' }" --}}
                                            {{-- x-tooltip="tooltip" --}}
                                            type="button"
                                            wire:click="$dispatch('openModal', { component: 'modal-prevent-delete', arguments: {model_id: {{ $order->id }}, emit: 'order:delete'} })"
                                            class="block px-4 py-2 text-sm text-gray-700">
                                            {{ __('Destroy') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>

@push('styles')
    <script type="text/javascript" src="{{ asset('dist/jquery-v3.2.1.js') }}"></script>
    <script src="{{ asset('dist/summernote-lite-v0.8.18.min.js') }}"></script>
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
