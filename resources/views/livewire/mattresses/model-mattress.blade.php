<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Mattress') . ' #' . $model->id : __('New Mattress') }}" breadcrumbs="mattresses" />
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

                <x-form.group-left :label="__('Dimension')">
                    <div class="sm:max-w-md">
                        <x-wireui:select
                            label="Select Dimension"
                            placeholder="Select one Dimension"
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

                <x-form.group-left :label="__('Available')">
                    <div class="sm:max-w-md">
                        <x-wireui:toggle wire:model="form.available" name="available" rounded="full" xl />
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
                <x-wireui:button negative href="{{ route('mattresses.index') }}">
                    {{ __('Cancelar') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
