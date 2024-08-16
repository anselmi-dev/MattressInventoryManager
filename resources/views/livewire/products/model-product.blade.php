<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Part') . ' #' . $model->id : __('New Part') }}" breadcrumbs="parts" />
    <x-page.content>

        <x-loading-livewire/>

        @php
            $has_combinations = (bool)$model->combinations()->count();
        @endphp
        
        <x-form.container-left>
            <x-form.section-left>
                <x-form.group-left :label="__('Type')">
                    <div class="sm:max-w-md">
                        <div
                            @class([
                                "selector-type-product",
                                "selector-type-product--disble" => $has_combinations
                            ])
                        >
                            @foreach ($this->types as $type)
                                <div class="selector-type-product__item">
                                    <input class="selector-type-product__input" type="radio" wire:model="form.type" value="{{ $type['id'] }}" name="type" id="{{ $type['label'] }}" @disabled($has_combinations)>
                                    <label for="{{ $type['label'] }}" class="selector-type-product__label">
                                        <span class="selector-type-product__icon">
                                            @switch($type['id'])
                                                @case('cover')
                                                    <x-icons.cover/>
                                                    @break
                                                @case('base')
                                                    <x-icons.base/>
                                                    @break
                                                @case('top')
                                                    <x-icons.top/>
                                                    @break
                                                @default
                                            @endswitch
                                        </span>
                                        <span class="selector-type-product__name">{{ $type['label'] }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @if ($has_combinations)    
                            <x-alerts.warning class="mt-2">
                                {{ __('The product type cannot be edited as it is associated with a combination.') }}
                            </x-alerts.warning>
                        @endif
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Code')">
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Code')"
                            wire:model="form.code"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Dimension')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Dimension')"
                            :options="$this->dimensions"
                            option-label="label"
                            option-value="id"
                            wire:model.defer="form.dimension_id"
                        />
                    </div>
                </x-form.group-left>
                
                <x-form.group-left :label="__('Stock')">
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Stock')"
                            wire:model="form.stock"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Visible')">
                    <div class="sm:max-w-md">
                        <x-wireui:toggle wire:model="form.visible" name="visible" rounded="full" xl />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Description')">
                    <div class="sm:max-w-md">
                        <x-wireui:textarea wire:model="form.description" :rows="2" placeholder="{{ __('Write your notes') }}" />
                    </div>
                </x-form.group-left>
                
                <x-wireui:errors/>

            </x-form.section-left>
            <x-slot name="actions">
                <x-wireui:button black href="{{ route('products.index') }}">
                    {{ __('Cancel') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
