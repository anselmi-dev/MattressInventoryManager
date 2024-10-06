<x-page.container>
    <x-page.heading title="{{ __('Dimension') }} #{{ $model->code }}" breadcrumbs="dimensions.show"
        :model="$model">
        <x-slot name="actions">
            <div class="flex gap-1">
                <x-wireui:button primary href="{{ $model->route_edit }}">
                    {{ __('Edit') }}
                </x-wireui:button>
            </div>
        </x-slot>
    </x-page.heading>

    <x-page.content>
        <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
            <dl class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
                <div
                    class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 ">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ __('Code') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                        {{ $model->code }}</dd>
                </div>
                <div
                    class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 lg:border-l">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ __('Width') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                        {{ $model->width }}</dd>
                </div>
                <div
                    class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 sm:border-l">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ __('Height') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                        {{ $model->height }}</dd>
                </div>
                <div
                    class="flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-2 py-4 sm:px-3 lg:border-t-0 xl:px-4 sm:border-l">
                    <dt class="text-sm font-medium leading-6 text-gray-500">{{ __('Created at') }}</dt>
                    <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                        {{ optional($model->created_at)->format('Y-m-d') }}</dd>
                </div>
            </dl>
        </div>
    </x-page.content>

    <x-page.content>

        <x-loading-livewire />

        <x-page.heading title="{{ __('Products') }}" md />

        <div class="space-y-2 mt-2">
            <ul role="list"
                class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 rounded">
                @forelse($products as $product)
                    <li>
                        <x-products.card-product :product="$product" />
                    </li>
                @empty
                    <ul>
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="mt-2 max-w-xl text-sm text-gray-500">
                                    <p>{{ __('No record was found in the database') }}</p>
                                </div>
                            </div>
                        </div>
                    </ul>
                @endforelse
            </ul>

            {{ $products->links() }}
        </div>
    </x-page.content>
</x-page.container>
