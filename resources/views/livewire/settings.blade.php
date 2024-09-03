<x-page.container>
    <x-page.heading title="{{ __('Settings') }}" breadcrumbs="settings" />
    <x-page.content>

        <x-loading-livewire/>

        <x-form.container-left>
            <x-form.section-left>

                <x-form.group-left :label="__('Email')">
                    <x-slot name="description">
                        {{ __("Email that will be sent with the orders.") }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Email')"
                            type="email"
                            wire:model="email"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Number of days of stock')">
                    <x-slot name="description">
                        {{ __("Days used to calculate the basis for the average of previous sales.") }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Number of days of stock')"
                            wire:model="stock_days"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Number of days')">
                    <x-slot name="description">
                        {{ __("Days used for the average of previous sales.") }}
                    </x-slot>
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Number of days')"
                            wire:model="stock_media_days"
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