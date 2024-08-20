<x-page.container>
    <x-page.heading title="{{ __('Settings') }}" breadcrumbs="settings" />
    <x-page.content>

        <x-loading-livewire/>

        <x-form.container-left>
            <x-form.section-left>

                <x-form.group-left :label="__('Critical stock (red)')">
                    <x-slot name="description">
                        {{ __("The number where the stock will be displayed in red, indicating danger.") }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Stock')"
                            wire:model="alert_danger"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Low stock (yellow)')">
                    <x-slot name="description">
                        {{ __("The number where the stock will be displayed in yellow, indicating caution.") }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Stock')"
                            wire:model="alert_warning"
                        />
                    </div>
                </x-form.group-left>

                {{-- <x-form.group-left :label="__('High Stock')">
                    <x-slot name="description">
                        {{ __("The indicator will turn green when the stock level is higher than the threshold defined as 'Low Stock (Yellow)'.") }}
                    </x-slot>
                </x-form.group-left> --}}

                <x-form.group-left :label="__('Notification')">
                    <x-slot name="description">
                        {{ __('') }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:toggle wire:model="notification" name="visible" rounded="full" xl />
                    </div>
                </x-form.group-left>

                <x-wireui:errors/>

            </x-form.section-left>
            <x-slot name="actions">
                <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                   {{ __('Save') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>