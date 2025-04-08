@props([
    'value',
    'stock_order' => null,
    'AVERAGE_SALES_DIFFERENCE' => 0,
    'AVERAGE_SALES' => 0,
    'AVERAGE_SALES_PER_DAY' => 0,
    'TOTAL_SALES' => 0,
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
    $color = color_average_stock($value, $AVERAGE_SALES_DIFFERENCE);
    $media = $AVERAGE_SALES == 0 ? 0 : ($value * 100 ) / $AVERAGE_SALES;
    if ($media > 100)
        $message = 'Posee más del 100% del Stock requerido, ya que solo se requiere ' . ($AVERAGE_SALES == 1 ? 'una unidad' : $AVERAGE_SALES . ' unidades') . ' en los próximos ' . settings()->get('stock:days', 10) . ' días';
    else
        $message = $color != 'green' ? 'Posee un ' . round($media, 0) . '% del Stock requerido' : 'Stock suficiente';
@endphp

<div>
    <div class="flex items-center gap-1 w-fit relative bg-{{ $color }}-100 rounded-full px-2"
        x-data="{ tooltip: '{{ $message }}' }"
        x-tooltip="tooltip"
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