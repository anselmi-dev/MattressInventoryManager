<div>
    @if($hasErrors)
        <div class="bg-red-50 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
            <p class="text-sm text-red-500 dark:text-red-400">
                Los datos de la factura no coinciden con los datos de la base de datos.
            </p>
        </div>
    @endif

    @forelse ($data as $index => $record)
        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4">
            <h4 class="font-medium text-gray-900 dark:text-white mb-3">
                Registro {{ $index + 1 }}
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if(isset($record->CODFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Código Factura</label>
                        <p class="text-sm text-gray-900 dark:text-white font-mono">{{ $record->CODFAC }}</p>
                    </div>
                @endif

                @if(isset($record->ARTLFA))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Código Artículo</label>
                        <p class="text-sm text-gray-900 dark:text-white font-mono">{{ $record->ARTLFA }}</p>
                    </div>
                @endif

                @if(isset($record->CANLFA))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Cantidad</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $record->CANLFA }}</p>
                    </div>
                @endif

                @if(isset($record->TOTLFA))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Línea</label>
                        <p class="text-sm text-gray-900 dark:text-white font-mono">{{ number_format($record->TOTLFA, 2) }} €</p>
                    </div>
                @endif

                @if(isset($record->DESLFA))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Descripción</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $record->DESLFA }}</p>
                    </div>
                @endif

                @if(isset($record->TOTFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Factura</label>
                        <p class="text-sm text-gray-900 dark:text-white font-mono font-semibold">{{ number_format($record->TOTFAC, 2) }} €</p>
                    </div>
                @endif

                @if(isset($record->CLIFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Cliente</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $record->CLIFAC }}</p>
                    </div>
                @endif

                @if(isset($record->CNOFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Cliente</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $record->CNOFAC }}</p>
                    </div>
                @endif

                @if(isset($record->ESTFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($record->ESTFAC === 'A') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @elseif($record->ESTFAC === 'P') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                            @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                            @endif">
                            {{ $record->ESTFAC }}
                        </span>
                    </div>
                @endif

                @if(isset($record->FECFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha Factura</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($record->FECFAC)->format('d/m/Y H:i') }}</p>
                    </div>
                @endif

                @if(isset($record->TIPFAC))
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo Factura</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $record->TIPFAC }}</p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-8">
            <div class="text-gray-500 dark:text-gray-400">
                <svg class="mx-auto h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg font-medium">No se encontraron datos</p>
                <p class="text-sm">No hay información disponible en Factusol para esta factura.</p>
            </div>
        </div>
    @endforelse
</div>
