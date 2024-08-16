<x-page.container>
    <x-page.heading title="{{ $model->exists ? __('Edit User') . ' #' . $model->id : __('New User') }}" breadcrumbs="users" />
    <x-page.content>
        <x-loading-livewire/>
        
        <x-form.container-left>
            <x-form.section-left>
                <x-form.group-left :label="__('Name')">
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Name')"
                            wire:model="form.name"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Email')">
                    <div class="sm:max-w-md">
                        <x-wireui:input
                            :placeholder="__('Email')"
                            wire:model="form.email"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Password')">
                    <div class="sm:max-w-md">
                        <x-wireui:password
                            :placeholder="__('Password')"
                            wire:model="form.password"
                        />
                    </div>
                </x-form.group-left>


                <x-form.group-left :label="__('Role')">
                    <div class="sm:max-w-md | uppercase">
                        @if ($model->exists)
                            {{ __($model->role->name) }}
                        @else
                            {{ __('operator') }}
                        @endif
                    </div>
                </x-form.group-left>
                
                <x-wireui:errors/>

            </x-form.section-left>
            <x-slot name="actions">
                @if ($model->hasRole(['admin', 'develop']) && auth()->user()->email != $model->email)
                    <x-alerts.warning class="p-2 flex-1">
                        <span class="flex justify-between gap-2 items-center w-full flex-1">
                            <span>
                                {{ __("You cannot edit a user with a role equal to or higher than yours.") }}
                            </span>
                            <x-wireui:button black href="{{ route('users.index') }}" xs>
                                {{ __('Cancel') }}
                            </x-wireui:button>
                        </span>
                    </x-alerts.warning>
                @else     
                    <x-wireui:button black href="{{ route('users.index') }}">
                        {{ __('Cancel') }}
                    </x-wireui:button>

                    <x-wireui:button primary type="button" spinner="submit" wire:target="submit" primary right-icon="check" wire:click="submit">
                        {{ $model->exists ? __('Guardar') : __('Crear') }}
                    </x-wireui:button>
                @endif
            </x-slot>
        </x-form.container-left>
    </x-page.content>
</x-page.container>
