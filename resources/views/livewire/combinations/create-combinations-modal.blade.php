<div class="w-full px-4 pb-4 pt-5 sm:p-6">
    {{-- sm:w-full sm:max-w-md md:max-w-xl lg:max-w-3xl --}}
    <div class="flex flex-col relative">
        <x-loading-livewire/>
        <x-page.heading>
            <x-slot name="title">
                <span class="block">{{ __('Manufacture') }}</span>
                <span class="text-md">{{ $combination->code }}</span>
            </x-slot>
            <x-slot name="description">
                {{ __("To manufacture the combination, ensure that the minimum stock of each part is available, as you cannot create more units than what is recorded in the system.") }}
            </x-slot>
        </x-page.heading>
    
        <x-form.container-left>

            <x-form.section-left>
                <x-form.group-left :label="__('Parts')">
                    <x-cards.products-combination :products="$combination->combinedProducts">
                    </x-cards.products-combination>
                </x-form.group-left>

                {{--
                <x-form.group-left :label="__('Parts')">
                    <div class="sm:max-w-md">
                        <table class="border-collapse border border-slate-400  w-full">
                            <thead>
                                <tr>
                                    <th class="border border-slate-300 p-1">{{ __('Tipo') }}</th>
                                    <th class="border border-slate-300 p-1">{{ __('Code') }}</th>
                                    <th class="border border-slate-300 p-1">{{ __('Stock') }}</th>
                                </tr>
                            </thead>
                            @foreach ($combination->products as $item)
                                <tr>
                                    <td class="border border-slate-300 p-1">{{ __($item->type) }}</td>
                                    <td class="border border-slate-300 p-1">
                                        @php
                                            $product_code = $item->code;
                                        @endphp
                                        @if ($product_code)    
                                            <a href="{{ route('products.model', ['model' => $product_code->id]) }}" class="text-app-default">
                                                {{ $product_code->value }}
                                            </a>
                                        @else
                                            N/D
                                        @endif
                                    </td>
                                    <td class="border border-slate-300 pl-1">{{ $item->stock }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </x-form.group-left>
                --}}

                <x-form.group-left :label="__('Dimension')">
                    <div class="sm:max-w-md">
                        @php
                            $dimension = $combination->dimension;
                        @endphp
                        @if ($dimension)
                            <table class="border-collapse border border-slate-400  w-full">
                                <thead>
                                    <tr>
                                        <th class="border border-slate-300 p-1">{{ __('Code') }}</th>
                                        <th class="border border-slate-300 p-1">{{ __('Dimension') }}</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td class="border border-slate-300 p-1">
                                        <a href="{{ route('dimensions.model', ['model' => $dimension->id]) }}" class="text-app-default">
                                            {{ $dimension->code }}
                                        </a>
                                    </td>
                                    <td class="border border-slate-300 p-1 whitespace-nowrap">
                                        {{ $combination->dimension->width }} x {{ $combination->dimension->height }}
                                    </td>
                                </tr>
                            </table>
                        @else
                            N/D
                        @endif
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Quantity')">
                    <div class="sm:max-w-md">
                        <x-wireui:number
                            :placeholder="__('Quantity')"
                            wire:model="quantity"
                        />
                    </div>
                </x-form.group-left>

                <x-form.group-left :label="__('Confirm')">
                    <div class="sm:max-w-md">
                        <x-wireui:checkbox wire:model="confirm" label="{{ __('Confirm to proceed with the manufacturing process') }}" value="true">
                        </x-wireui:checkbox>
                    </div>
                </x-form.group-left>

                <x-wireui:errors/>

            </x-form.section-left>
            
            <x-slot name="actions">
                <x-wireui:button right-icon="check" type="button" negative wire:click="submit()">
                    {{ __('Yes, proceed') }}
                </x-wireui:button>
                <x-wireui:button black type="button" primary wire:click="$dispatch('closeModal')">
                    {{ __('Cancel') }}
                </x-wireui:button>
            </x-slot>
        </x-form.container-left>
    </div>
</div>

