<x-page.container>
    <x-page.heading title="{{ __('Activity Logs') }}" breadcrumbs="activity">
        <x-slot name="actions">
            <div class="flex flex-wrap gap-1">
            </div>
        </x-slot>
    </x-page.heading>

    <x-page.content>
        <x-tables.container-overflow>
            <x-tables.default>
                <x-slot name="thead">
                    <tr class="divide-x divide-gray-200">
                        <x-tables.th>
                            {{ __('Id') }}
                        </x-tables.th>
                        <x-tables.th>
                            {{ __('Usuario') }}
                        </x-tables.th>
                        <x-tables.th>
                            {{ __('Subject type') }}
                        </x-tables.th>
                        <x-tables.th>
                            {{ __('Changes') }}
                        </x-tables.th>
                        <x-tables.th>
                            {{ __('Description') }}
                        </x-tables.th>
                        <x-tables.th>
                            {{ __('Creado el') }}
                        </x-tables.th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    @forelse ($collection as $item)
                        <tr class="divide-x divide-gray-200">
                            <x-tables.td>
                                {{ $item->id }}
                            </x-tables.td>
                            <x-tables.td>
                                {{ $item->causer ? $item->causer->name : __('System') }}
                            </x-tables.td>
                            <x-tables.td>
                                {{ $item->subject_type  }}
                            </x-tables.td>
                            <x-tables.td>
                                {{ count($item->changes) }}
                            </x-tables.td>
                            <x-tables.td>
                                {{ $item->description }}
                            </x-tables.td>
                            <x-tables.td>
                                <div class="my-0 py-0">{{ $item->created_at->format('Y-m-d h:i') }}</div>
                            </x-tables.td>
                        </tr>
                        {{-- <tr>
                            <x-tables.td colspan="4">
                                @foreach ($item->changes as $change)
                                    @json($change)
                                @endforeach
                            </x-tables.td>
                        </tr> --}}
                    @empty
                        <x-tables.tr-empyt></x-tables.tr-empyt>
                    @endforelse
                </x-slot>
            </x-tables.default>
            <x-slot name="paginate">
                {{ $collection->links() }}
            </x-slot>
        </x-tables.container-overflow>
    </x-page.content>
</x-page.container>
