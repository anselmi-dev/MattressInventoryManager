@props([
    'value',
    'average_sales_quantity' => 0,
    'average_sales_media' => 0,
    'stock_order' => null,
])

{{-- bg-blue-600 --}}
{{-- bg-blue-100 --}}
{{-- bg-red-100 --}}
{{-- bg-yellow-100 --}}
{{-- bg-emerald-100 --}}

{{-- bg-emerald-100 --}}
{{-- bg-emerald-600 --}}
{{-- bg-orange-100 --}}
{{-- bg-orange-600 --}}
{{-- bg-red-100 --}}
{{-- bg-red-600 --}}
@php
    $color = color_average_stock($value, $average_sales_quantity);
    $media = $average_sales_quantity == 0 ? 0 : ($value * 100 ) / $average_sales_quantity
@endphp
<div>
<div class="flex items-center gap-1 w-fit relative bg-{{ $color }}-100 rounded-full px-2"
    x-data="{ tooltip: 'Posee un {{ round($media, 0) . '%' }} del Stock requerido' }"
    x-tooltip="tooltip"
    {{-- title="{{ $row }}" --}}
    >
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
</div>