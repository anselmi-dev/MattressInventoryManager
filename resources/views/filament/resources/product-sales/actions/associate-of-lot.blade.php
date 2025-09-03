<div class="flex flex-col space-y-4 divide-y divide-slate-200">
    <h2 class="tracking-tight text-gray-900 text-base font-bold">
        {{ $record->name }}
    </h2>

    @if ($record->product_lot)
        <p class="mt-2 leading-none text-gray-700">
            El producto ya está asociado con el lote <strong>{{ $record->product_lot->name }}</strong> si desea susbstituirlo por otro, seleccione otro lote y pulse en el botón de "Enviar"
        </p>
    @endif
</div>
