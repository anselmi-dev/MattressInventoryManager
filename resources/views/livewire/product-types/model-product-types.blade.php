<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit Product Type') . ' #' . $model->code: __('New Product Type') }}" breadcrumbs="product_types" />
    <x-page.content>

        <x-loading-livewire/>

        <x-form.container-left>
            <x-form.section-left>
                <x-form.group-left :label="__('Name')">
                    <x-slot name="description">
                        {{-- {{ __('The code must be unique. It is recommended to start with :string', ['string' => '"DIM"']) }} --}}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Name')"
                            wire:model="form.name"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Part')">
                    <x-slot name="description">
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:toggle lg wire:model.defer="form.part" />
                    </div>
                </x-form.group-left>
                
                <x-wireui:errors/>

            </x-form.section-left>

            <x-slot name="actions">
                <x-wireui:button black href="{{ route('product_types.index') }}">
                    {{ __('Cancel') }}
                </x-wireui:button>

                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                    {{ $model->exists ? __('Guardar') : __('Crear') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
