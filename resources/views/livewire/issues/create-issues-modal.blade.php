<div class="w-full px-4 pb-4 pt-5 sm:p-6">
    {{-- sm:w-full sm:max-w-md md:max-w-xl lg:max-w-3xl --}}
    <div class="flex flex-col relative">
        <x-loading-livewire/>
        
        <x-page.heading title="{{ isset($form['id']) ? __('Update incident') : __('Create incident') }}">
            <x-slot name="description">
                {{-- {{ __("To manufacture the combination, ensure that the minimum stock of each part is available, as you cannot create more units than what is recorded in the system.") }} --}}
            </x-slot>
        </x-page.heading>
    
        <x-form.container-left>
            <x-form.section-left>

                <x-form.group :label="__('Type')">
                    <div>
                        <x-wireui:select
                            :placeholder="__('Select one Type')"
                            :options="$this->types"
                            option-label="label"
                            option-value="id"
                            wire:model="form.type"
                        />
                    </div>
                </x-form.group>

                @if (isset($form['created_at']))
                    <x-form.group :label="__('Created at')">
                        <div>
                            <x-wireui:datetime-picker wire:model="form.created_at" placeholder="{{ __('Created at') }}" disabled/>
                        </div>
                    </x-form.group>
                @endif
                
                <x-form.group :label="__('Note')">
                    <div>
                        <x-wireui:textarea wire:model="form.note" :rows="2" placeholder="{{ __('Write your notes') }}" />
                    </div>
                </x-form.group>
                
            <x-wireui:errors/>

            </x-form.section-left>
            
            <x-slot name="actions">
                <x-wireui:button black type="button" primary wire:click="$dispatch('closeModal')">
                    {{ __('Cancel') }}
                </x-wireui:button>
                <x-wireui:button right-icon="check" type="button" primary wire:click="submit()">
                    {{ __('Yes, proceed') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </div>
</div>

