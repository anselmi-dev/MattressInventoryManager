<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Dimension') . ' #' . $model->code: __('New Dimension') }}" breadcrumbs="dimensions" />
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

                <x-form.group-left :label="__('Width')">
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Width')"
                            wire:model="form.width"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Height')">
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Height')"
                            wire:model="form.height"
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
                <x-wireui:button black href="{{ route('dimensions.index') }}">
                    {{ __('Cancel') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
