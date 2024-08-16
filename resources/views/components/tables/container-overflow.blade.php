@props(['overflow' => true, 'paginate' => null])

<div {{ $attributes->merge(["class" => "flow-root space-y-2"]) }}>
    <div @class([
        'overflow-x-auto' => $overflow,
        'overflow-auto md:overflow-visible' => !$overflow
    ])>
        <div class="inline-block min-w-full align-middle w-full">
            {{ $slot }}
        </div>
    </div>

    @if ($paginate)
        <div class="w-full">
            {{ $paginate }}
        </div>
    @endif
</div>
