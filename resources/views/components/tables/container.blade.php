<div {{ $attributes->merge(['class' => 'space-y-2 flex flex-col w-full']) }}>
    <div class="mt-5 ring-1 ring-gray-300 sm:mx-0 rounded w-full">
        {{ $slot }}
    </div>
    @if ($paginate)
        <div class="w-full">
            {{ $paginate }}
        </div>
    @endif
</div>
