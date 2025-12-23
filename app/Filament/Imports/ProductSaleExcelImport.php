<?php

namespace App\Filament\Imports;

use App\Models\ProductSaleImport;
use App\Events\ProductSaleImportCompletedEvent;
use EightyNine\ExcelImport\EnhancedDefaultImport;
use Illuminate\Support\Collection;

class ProductSaleExcelImport extends EnhancedDefaultImport
{
    protected bool $updateExisting = false;

    protected bool $shouldCreateRecord = true;

    protected array|Collection $requiredHeaders = [];

    public function __construct(
        string|object $model,
        public array $attributes = []
    ) {
        // Asegurar que $model sea una clase de modelo (string)
        if (is_object($model)) {
            $model = get_class($model);
        }

        parent::__construct($model, $attributes);
    }

    public function setUpdateExisting(bool $updateExisting): void
    {
        $this->updateExisting = $updateExisting;
    }

    /**
     * Define la fila donde se encuentran los encabezados.
     * La numeración es basada en 1 (no 0).
     *
     * @return int Número de fila donde están los encabezados (1 = primera fila, 2 = segunda fila, etc.)
     */
    public function headingRow(): int
    {
        // Por defecto, los encabezados están en la primera fila
        // Si tus encabezados están en otra fila, cambia este valor
        // Ejemplo: si están en la fila 2, retorna 2
        return 7;
    }

    protected function beforeCollection(Collection $collection): void
    {
        // Obtener updateExisting de customImportData si está disponible
        if (isset($this->customImportData['updateExisting'])) {
            $this->updateExisting = (bool) $this->customImportData['updateExisting'];
        }

        // Validar que el archivo no esté vacío
        if ($collection->isEmpty()) {
            $this->stopImportWithError('El archivo está vacío.');
        }

        // Validar encabezados requeridos
        $this->requiredHeaders = collect([
            0 => 'documento',
            1 => 'codigo',
            2 => 'fecha',
            3 => 'prov_cli',
            4 => 'serie_lote',
            5 => 'articulo',
            6 => 'unidades',
            7 => 'fabr_env',
            8 => 'cons_pref',
        ]);

        // $this->validateHeaders($requiredHeaders, $collection);
    }

    protected function beforeCreateRecord(array $data, $row): void
    {
        // Resetear el flag
        $this->shouldCreateRecord = true;

        // Validar que el documento sea FACTURA
        $documento = strtoupper(trim($data['documento'] ?? ''));
        if ($documento !== 'FACTURA') {
            // Saltar esta fila, no detener todo el proceso
            $this->shouldCreateRecord = false;
            return;
        }

        // Validar si ya existe el registro (si updateExisting está habilitado)
        if ($this->updateExisting) {
            $productSaleImport = ProductSaleImport::where([
                'documento'  => $data['documento'] ?? null,
                'codigo'     => $data['codigo'] ?? null,
                'fecha'      => $data['fecha'] ?? null,
                'serie_lote' => $data['serie_lote'] ?? null,
                'articulo'   => $data['articulo'] ?? null,
                'unidades'   => $data['unidades'] ?? null,
            ])->first();

            if ($productSaleImport) {
                if ($productSaleImport->isError()) {
                    // Resetear el estado y continuar (se creará un nuevo registro)
                    $productSaleImport->setStatusPending();
                } else {
                    // Ya existe y no es error, saltar esta fila
                    $this->shouldCreateRecord = false;
                    return;
                }
            }
        }
    }

    protected function afterCollection(Collection $collection): void
    {
        // Disparar evento de completado
        ProductSaleImportCompletedEvent::dispatch();
    }

    public function collection(Collection $collection)
    {
        // Validación inicial antes de procesar
        $this->beforeCollection($collection);

        // Procesar cada fila
        foreach ($collection as $row) {

            $data = $this->requiredHeaders->combine(collect($row)->values())->toArray();

            // Fusionar con datos adicionales si existen
            if (filled($this->additionalData)) {
                $data = array_merge($data, $this->additionalData);
            }

            // Aplicar mutator después de validación si existe
            if ($this->afterValidationMutator) {
                $data = call_user_func(
                    $this->afterValidationMutator,
                    $data
                );
            }

            // Validar antes de crear el registro (esto establece shouldCreateRecord)
            $this->beforeCreateRecord($data, $row);

            // Solo crear si shouldCreateRecord es true
            if ($this->shouldCreateRecord) {
                $this->model::create($data);

                // Llamar al hook después de crear
                $this->afterCreateRecord($data, $row);
            }
        }

        // Ejecutar después de procesar toda la colección
        $this->afterCollection($collection);

        return $collection;
    }
}
