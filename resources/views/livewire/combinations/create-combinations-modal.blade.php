<div class="w-full px-4 pb-4 pt-5 sm:p-6">
    {{-- sm:w-full sm:max-w-md md:max-w-xl lg:max-w-3xl --}}
    <div class="flex flex-col relative">
        <x-loading-livewire/>
        <x-page.heading>
            <x-slot name="title">
                <span class="block">{{ __('Manufacture') }}</span>
                <span class="text-md text-gray-700">{{ $combination->code }}</span>
            </x-slot>
            <x-slot name="description">
                {{ __("To manufacture the combination, ensure that the minimum stock of each part is available, as you cannot create more units than what is recorded in the system.") }}
            </x-slot>
        </x-page.heading>
    
        <x-form.container-left>

            <x-form.section-left>
                {{-- <x-form.group-left :label="__('Parts')">
                    <x-cards.products-combination :products="$combination->combinedProducts">
                    </x-cards.products-combination>
                </x-form.group-left> --}}

                <x-form.group-left :label="__('Parts')">
                    <div class="sm:max-w-lg">
                        <table class="border-collapse border rounded border-slate-400  w-full">
                            <thead>
                                <tr>
                                    <th class="border border-slate-300 p-1">{{ __('Parte') }}</th>
                                    <th class="border border-slate-300 p-1">{{ __('Stock') }}</th>
                                </tr>
                            </thead>
                            @forelse ($combination->combinedProducts as $item)
                                <tr @class([
                                    'bg-negative-50' => $item->stock == 0
                                ])>
                                    <td class="border border-slate-300 p-1">
                                        <div class="flex gap-1">
                                            <span class="block text-xs" title="{{ $item->code }}">{{ $item->reference }}</span>
                                        </div>
                                        <div class="block">
                                            <a href="{{ $item->route_show }}" wire:navigate class="text-app-default">
                                                {{ $item->name }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="border border-slate-300 pl-1 text-center">{{ $item->stock }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td  colspan="2">
                                        <x-alerts.warning>
                                            La combinación no tiene partes asociadas. Por favor, revisa y asocia las partes correspondientes a la combinación.
                                        </x-alerts.warning>
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Dimension')">
                    <div class="sm:max-w-lg">
                        @php
                            $dimension = $combination->dimension;
                        @endphp
                        <table class="border-collapse border border-slate-400  w-full">
                            <thead>
                                <tr>
                                    <th class="border border-slate-300 p-1">{{ __('Code') }}</th>
                                    <th class="border border-slate-300 p-1">{{ __('Dimension') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if ($dimension)
                                        <td class="border border-slate-300 p-1">
                                            <a href="{{ route('dimensions.model', ['model' => $dimension->id]) }}" wire:navigate class="text-app-default">
                                                {{ $dimension->code }}
                                            </a>
                                        </td>
                                        <td class="border border-slate-300 p-1 whitespace-nowrap">
                                            {{ $combination->dimension->width }} x {{ $combination->dimension->height }}
                                        </td>
                                    @else
                                        <td colspan="2">
                                            <x-alerts.warning>
                                                La combinación no tiene una dimensión asociada
                                            </x-alerts.warning>
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Quantity')">
                    <div class="sm:max-w-lg">
                        <x-wireui:number
                            :placeholder="__('Quantity')"
                            wire:model="quantity"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Confirm')">
                    <div class="sm:max-w-lg">
                        <x-wireui:checkbox wire:model="confirm" label="{{ __('Confirm to proceed with the manufacturing process') }}" value="true">
                        </x-wireui:checkbox>
                    </div>
                </x-form.group-left>

                <x-wireui:errors/>

            </x-form.section-left>
            
            <x-slot name="actions">
                <x-wireui:button black type="button" primary wire:click="$dispatch('closeModal')">
                    {{ __('Cancel') }}
                </x-wireui:button>
                <x-wireui:button right-icon="check" type="button" negative wire:click="submit()">
                    {{ __('Yes, proceed') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </div>
</div>

