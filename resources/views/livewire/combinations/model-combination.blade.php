<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Combination') . ' #' . $model->id : __('New Combination') }}" breadcrumbs="combinations" />
    <x-page.content>

        <x-loading-livewire/>

        <x-form.container-left>
            <x-form.section-left>
                <x-form.group-left :label="__('Code')">
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Code')"
                            wire:model="form.code"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Base')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Base')"
                            :options="$this->bases"
                            option-label="code"
                            option-value="id"
                            wire:model.defer="form.base_id"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Cover')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Cover')"
                            :options="$this->covers"
                            option-label="code"
                            option-value="id"
                            wire:model.defer="form.cover_id"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Top')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            :placeholder="__('Select one Top')"
                            :options="$this->tops"
                            option-label="code"
                            option-value="id"
                            wire:model.defer="form.top_id"
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
                        <x-wireui:textarea wire:model="form.description" :rows="2" placeholder="{{ __('write your notes') }}" />
                    </div>
                </x-form.group-left>
                
                <x-wireui:errors/>

            </x-form.section-left>
            
            <x-slot name="actions">
                <x-wireui:button negative href="{{ route('combinations.index') }}">
                    {{ __('Cancelar') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
