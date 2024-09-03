@props(['stock_order' => null, 'row' => null, 'value'])

<div class="flex items-center gap-1"
    title="{{ $row }}"
    >
    @php
        $color = color_average_stock($value, $row);
    @endphp
    <span class="relative flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $color }}-600 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-{{ $color }}-600"></span>
    </span>
    @if ($stock_order)
        <span>{{ $value }} + {{ $stock_order }}</span>
    @else
        <span>{{ $value }}</span>
    @endif
</div>