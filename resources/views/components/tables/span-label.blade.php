
<span {{ $attributes->merge(['class' => 'inline-block']) }}>
    <span class="grid leading-none">
        <small class="text-gray-400 leading-none sm:hidden" style="font-size: .6rem">
            {{ $label }}
        </small>
        <span class="break-all">{{ $slot }}</span>
    </span>
</span>
