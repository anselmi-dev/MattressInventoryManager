<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Part') . ' #' . $model->code : __('New Part') }}" breadcrumbs="parts" />
    <x-page.content>

        <x-loading-livewire/>

        @php
            $has_combinations = (bool)$model->partOfCombinations()->count();
        @endphp
        
        <x-form.container-left>
            <x-form.section-left>
                <x-form.group-left :label="__('Type')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Type')"
                            :options="$this->product_types"
                            wire:model.defer="form.type"
                            :disabled="$has_combinations"
                        />

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

                <x-form.group-left :label="__('Name')">
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Name')"
                            wire:model="form.name"
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

                {{--
                <x-form.group-left :label="__('Visible')">
                    <div class="sm:max-w-md">
                        <x-wireui:toggle wire:model="form.visible" name="visible" rounded="full" xl />
                    </div>
                </x-form.group-left>
                --}}

                <x-form.group-left :label="__('Description')">
                    <div class="sm:max-w-md">
                        <x-wireui:textarea wire:model="form.description" :rows="2" placeholder="{{ __('Write your notes') }}" />
                    </div>
                </x-form.group-left>
                
                <x-wireui:errors/>

            </x-form.section-left>
            <x-slot name="actions">
                <x-wireui:button black href="{{ route('products.index') }}" wire:navigate>
                    {{ __('Cancel') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="preventSubmit" wire:target="preventSubmit" primary right-icon="check" wire:click="preventSubmit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
