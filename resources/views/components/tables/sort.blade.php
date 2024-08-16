@props(['direction' => 'default'])

<span class="flex items-center justify-between">
    <span>{{ $slot }}</span>
    <button type="button" class="border border-gray-100 rounded flex flex-col">
        <x-heroicon-s-chevron-up @class([
            "h-3 w-3 shrink-0",
            'opacity-20' => $direction == 'asc'
        ])/>
        <x-heroicon-s-chevron-down @class([
            "h-3 w-3 shrink-0",
            'opacity-20' => $direction == 'desc'
        ])/>
    </button>
</span>
