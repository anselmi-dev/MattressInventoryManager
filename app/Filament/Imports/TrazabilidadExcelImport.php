<?php

namespace App\Filament\Imports;

use App\Models\ProductSaleImport;
use App\Events\ProductSaleImportCompletedEvent;
use EightyNine\ExcelImport\EnhancedDefaultImport;
use Illuminate\Support\Collection;

class TrazabilidadExcelImport extends EnhancedDefaultImport
{
    protected bool $updateExisting = false;

    protected bool $shouldCreateRecord = true;

    protected array|Collection $requiredHeaders = [];

    public function __construct(
        string|object $model,
        public array $attributes = []
    ) {
        if (is_object($model)) {
            $model = get_class($model);
        }

        parent::__construct($model, $attributes);
    }

    public function headingRow(): int
    {
        return 7;
    }

    protected function beforeCollection(Collection $collection): void
    {
        if (isset($this->customImportData['updateExisting'])) {
            $this->updateExisting = (bool) $this->customImportData['updateExisting'];
        }

        if ($collection->isEmpty()) {
            $this->stopImportWithError('El archivo está vacío.');
        }

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
    }

    protected function beforeCreateRecord(array $data, $row): void
    {
        $this->shouldCreateRecord = true;

        if ($this->updateExisting) {
            $existing = ProductSaleImport::where([
                'documento'  => $data['documento'] ?? null,
                'codigo'     => $data['codigo'] ?? null,
                'fecha'      => $data['fecha'] ?? null,
                'serie_lote' => $data['serie_lote'] ?? null,
                'articulo'   => $data['articulo'] ?? null,
                'unidades'   => $data['unidades'] ?? null,
            ])->first();

            if ($existing) {
                if ($existing->isError()) {
                    $existing->setStatusPending();
                } else {
                    $this->shouldCreateRecord = false;
                    return;
                }
            }
        }
    }

    protected function afterCollection(Collection $collection): void
    {
        ProductSaleImportCompletedEvent::dispatch();
    }

    public function collection(Collection $collection)
    {
        $this->beforeCollection($collection);

        foreach ($collection as $row) {
            $data = $this->requiredHeaders->combine(collect($row)->values())->toArray();

            if (filled($this->additionalData)) {
                $data = array_merge($data, $this->additionalData);
            }

            if ($this->afterValidationMutator) {
                $data = call_user_func($this->afterValidationMutator, $data);
            }

            $this->beforeCreateRecord($data, $row);

            if ($this->shouldCreateRecord) {
                $this->model::create($data);
                $this->afterCreateRecord($data, $row);
            }
        }

        $this->afterCollection($collection);

        return $collection;
    }
}
