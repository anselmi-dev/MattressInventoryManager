<div class="flex items-center gap-1">
    {{-- bg-yellow-600 --}}
    {{-- bg-yellow-500/20 --}}
    {{-- bg-green-600 --}}
    {{-- bg-green-500/20 --}}
    {{-- bg-emerald-600 --}}
    {{-- bg-emerald-500/20 --}}
    {{-- bg-red-600 --}}
    {{-- bg-red-500/20 --}}
    @php
        $color = color_stock($value);
    @endphp
    <span class="relative flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $color }}-600 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-{{ $color }}-600"></span>
    </span>
    <span>{{ $value }}</span>
</div>