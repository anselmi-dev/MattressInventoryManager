<x-filament-widgets::widget class="bg-yellow-100 {{ $this->hasFactusolProduct ? 'hidden' : '' }}">
    <x-filament::section class="bg-yellow-100">
        <div class="flex xl:items-start justify-between xl:flex-row flex-col gap-4">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-amber-500" />
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-gray-900">
                        Sin relación con Factusol
                    </h3>
                    <p class="mt-1 text-sm text-amber-800">
                        Este producto no tiene una relación establecida con FactusolProduct.
                        Esto puede afectar la sincronización de datos entre sistemas.
                    </p>
                    <p class="text-sm text-amber-800">
                        <strong>Recomendación:</strong>
                        Verifica que el código del producto coincida con el código en Factusol o contacta al administrador del sistema para establecer la relación.
                    </p>
                </div>
            </div>

            {{-- Acciones del widget --}}
            <div class="flex space-x-2 justify-end">
                @foreach ($this->getActions() as $action)
                    {{ $action }}
                @endforeach
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
