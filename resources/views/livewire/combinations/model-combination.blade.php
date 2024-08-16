<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Combination') . ' #' . $model->id : __('New Combination') }}" breadcrumbs="combinations">
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

                <x-form.group-left :label="__('Dimension')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Dimension')"
                            :options="$this->dimensions"
                            option-label="code"
                            option-value="id"
                            wire:model.live="form.dimension_id"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Base')">
                    <div
                        @class([
                            "sm:max-w-md",
                            "hidden" => !$form['dimension_id']
                        ])
                    >
                        <x-wireui:select
                            :placeholder="__('Select one Base')"
                            :options="$this->bases"
                            option-label="code.value"
                            option-value="id"
                            wire:model.defer="form.base_id"
                        />
                    </div>
                    @if (!$form['dimension_id'])
                        <div class="flex">
                            <div class="py-1 px-2 rounded border border-gray-50 | flex items-center gap-1 w-auto bg-gray-100">
                                <x-icons.pixelarticons-alert class="h-4 text-app-default"/>
                                <span>{{ __('Select one Dimension') }}</span>
                            </div>
                        </div>
                    @endif
                </x-form.group-left>

                <x-form.group-left :label="__('Cover')">
                    <div
                        @class([
                            "sm:max-w-md",
                            "hidden" => !$form['dimension_id']
                        ])
                    >
                        <x-wireui:select
                            :placeholder="__('Select one Cover')"
                            :options="$this->covers"
                            option-label="code.value"
                            option-value="id"
                            wire:model.defer="form.cover_id"
                        />
                    </div>
                    @if (!$form['dimension_id'])
                        <div class="flex">
                            <div class="py-1 px-2 rounded border border-gray-50 | flex items-center gap-1 w-auto bg-gray-100">
                                <x-icons.pixelarticons-alert class="h-4 text-app-default"/>
                                <span>{{ __('Select one Dimension') }}</span>
                            </div>
                        </div>
                    @endif
                </x-form.group-left>

                <x-form.group-left :label="__('Top')">
                    <div
                        @class([
                            "sm:max-w-md",
                            "hidden" => !$form['dimension_id']
                        ])
                    >
                        <x-wireui:select
                            :placeholder="__('Select one Top')"
                            :options="$this->tops"
                            option-label="code.value"
                            option-value="id"
                            wire:model.defer="form.top_id"
                        />
                    </div>
                    @if (!$form['dimension_id'])
                        <div class="flex">
                            <div class="py-1 px-2 rounded border border-gray-50 | flex items-center gap-1 w-auto bg-gray-100">
                                <x-icons.pixelarticons-alert class="h-4 text-app-default"/>
                                <span>{{ __('Select one Dimension') }}</span>
                            </div>
                        </div>
                    @endif
                </x-form.group-left>

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
