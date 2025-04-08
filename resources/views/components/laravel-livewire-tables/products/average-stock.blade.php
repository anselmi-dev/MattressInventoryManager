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
{{-- bg-gray-100 --}}

{{-- bg-gray-600 --}}
{{-- bg-emerald-600 --}}
{{-- bg-emerald-600 --}}
{{-- bg-orange-100 --}}
{{-- bg-orange-600 --}}
{{-- bg-red-100 --}}
{{-- bg-red-600 --}}
@php
    $color = color_average_stock($value, $AVERAGE_SALES);

    $media = $value > 0 ? ($AVERAGE_SALES / $value) * 100 : 0;

    $message = '<p>';

    if ($media > 100)
        $message .= 'Posee más del 100% del Stock requerido, ya que solo se requiere ' . ($AVERAGE_SALES == 1 ? 'una unidad' : $AVERAGE_SALES . ' unidades') . ' en los próximos ' . settings()->get('stock:days', 10) . ' días';
    elseif ($value == 0 && $AVERAGE_SALES == 0) {
        $color = 'gray';
        $message .= 'No posees stock, pero no se requiere';
    }
    else
        $message .= $color != 'green' ? 'Posee un ' . round($media, 0) . '% del Stock requerido' : 'Stock suficiente';

    $message .= '</p>';
    $message .= '<p> <hr>';
    $message .= 'Se requiere ' . $AVERAGE_SALES . ' unidades en los próximos ' . settings()->get('stock:days', 10) . ' días';
    $message .= '</p>';
@endphp

<div class="flex items-center gap-1">
    <div class="flex items-center gap-1 w-fit relative bg-{{ $color }}-100 rounded-full px-2 text-base"
        x-data="{ tooltip: '{{ $message }}' }"
        x-tooltip.html="tooltip"
    >
        <span class="relative flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $color }}-600 opacity-75"></span>
            {{-- <span class="relative inline-flex rounded-full h-4 w-4 bg-{{ $color }}-600"></span> --}}
            <svg class="relative inline-flex rounded-full h-4 w-4 bg-{{ $color }}-600 text-white cursor-help" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm1 13h-2v-6h2v6zm0-8h-2V7h2v2z" opacity=".3"></path><path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
        </span>
        @if ($stock_order)
            <span>{{ $value }} + {{ $stock_order }}</span>
        @else
            <span>{{ $value }}</span>
        @endif
    </div>
</div>