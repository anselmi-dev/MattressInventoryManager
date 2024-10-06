<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Combination') . ' #' . $model->code : __('New Combination') }}" breadcrumbs="combinations">
        <x-slot name="actions">
            @if ($model->exists)    
                <div class="flex flex-wrap gap-1">
                    <x-wireui:button primary right-icon="plus" type="button" wire:click="$dispatch('openModal', { component: 'combinations.create-combinations-modal', arguments: {combination: {{  $model->id }}}})">
                        {{ __('Manufacture') }}
                    </x-wireui:button>
                </div>
            @endif
        </x-slot>
    </x-page.heading>

    <x-page.content>
        <x-loading-livewire/>

        <x-form.container-left>
            <x-form.section-left>
                <x-form.group-left :label="__('Code')">
                    <x-slot name="description">
                        {{ __('model:code:description') }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Code')"
                            wire:model="form.code"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Name')">
                    <x-slot name="description">
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Name')"
                            wire:model="form.name"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Reference')">
                    <x-slot name="description">
                        {{ __("Represents the unique code stored in Factusol as 'EANART'.") }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Reference')"
                            wire:model="form.reference"
                        />
                    </div>
                </x-form.group-left>
                
                <x-form.group-left :label="__('Dimension')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Dimension')"
                            :options="$this->dimensions"
                            option-label="label"
                            option-value="value"
                            wire:model.live="form.dimension_id"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Parts')">
                    <div class="sm:max-w-md">
                        <div class="divide-y divide-gray-300 overflow-hidden w-full">
                            @forelse ($form['products'] as $key => $product)
                                <x-orders.card-product-order :product="$product">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <button type="button" primary wire:click="remove({{ $key }})" class="font-semibol text-app-primary">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </x-orders.card-product-order>
                            @empty
                                <div class="bg-gray-100 rounded | flex items-center justify-center p-3">
                                    <span>
                                        {{ __("Seleccione un producto") }}
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
                    </div>
                </x-form.group-left>

                @if ($model->exists)                    
                    <x-form.group-left :label="__('Stock')">
                        <x-slot name="description">
                            {{ __('combination:stock:description') }}
                        </x-slot>
                        <div class="sm:max-w-md">
                            <x-wireui:number
                                :placeholder="__('Stock')"
                                wire:model="form.stock"
                                disabled="{{ $model->exists }}"
                            />
                        </div>
                    </x-form.group-left>
                @endif

                <x-form.group-left :label="__('Description')">
                    <div class="sm:max-w-md">
                        <x-wireui:textarea wire:model="form.description" :rows="2" placeholder="{{ __('Write your notes') }}" />
                    </div>
                </x-form.group-left>
                
                <x-wireui:errors/>

            </x-form.section-left>
            
            <x-slot name="actions">
                <x-wireui:button black href="{{ route('combinations.index') }}">
                    {{ __('Cancel') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
