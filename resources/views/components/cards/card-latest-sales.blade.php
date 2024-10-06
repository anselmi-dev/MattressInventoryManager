<div class="flex flex-col">
    <div class="flex justify-between items-center space-x-1 p-2 rounded-t shadow-sm ring-1 ring-gray-900/5 bg-white">
        <h2 class="text-base md:text-lg font-semibold | flex items-center space-x-1">
            <x-icons.sale class="h-5"/>
            <span>{{ __('Latest Sales') }}</span>
        </h2>
        <a href="{{ route('sales.index') }}" wire:navigate class="flex space-x-1 justify-center items-center | font-semibold px-2 rounded-full |  transition-all text-app-primary dark:text-app-hover">
            {{ __('See more') }}
            <x-wireui:icon name="arrow-right" class="h-4"/>
        </a>
    </div>

    <ul role="list" class="divide-y divide-gray-100 overflow-hidden shadow-sm ring-1 ring-gray-900/5 rounded-b bg-white">
        @forelse ($collection as $sale)
            <li>
                <x-sales.card-sale :sale="$sale"/>
            </li>
        @empty
            <ul>
                <div class="bg-gray-50 shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            Ups!
                        </h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p>{{ __('No record was found in the database') }}</p>
                        </div>
                    </div>
                </div>                          
            </ul>
        @endforelse
    </ul>
</div>