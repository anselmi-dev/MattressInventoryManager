<?php

namespace App\Filament\Imports;

use App\Models\ProductSaleImport;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;
use Carbon\Carbon;
use Filament\Actions\Imports\Exceptions\RowImportFailedException;
use App\Models\ProductLot;
use App\Events\ProductSaleImportCompletedEvent;

class ProductSaleImportImporter extends Importer
{
    protected static ?string $model = ProductSaleImport::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('documento')
                ->label('Documento')
                ->requiredMapping(),
            ImportColumn::make('codigo')
                ->label('Código')
                ->requiredMapping(),
            ImportColumn::make('fecha')
                ->label('Fecha')
                ->requiredMapping(),
            ImportColumn::make('prov_cli')
                ->label('Prov/Cli'),
            ImportColumn::make('serie_lote')
                ->label('Serie/lote')
                ->requiredMapping(),
            ImportColumn::make('articulo')
                ->label('Artículo'),
            ImportColumn::make('unidades')
                ->label('Unidades')
                ->requiredMapping()
                ->numeric(),
            ImportColumn::make('fabr_env')
                ->label('Fabr/env'),
            ImportColumn::make('cons_pref')
                ->label('Cons.pref.'),
        ];
    }

    public function resolveRecord(): ProductSaleImport
    {
        if (!ProductLot::whereName($this->data['serie_lote'])->exists()) {
            throw new RowImportFailedException("No se encontró un lote con la referencia [{$this->data['serie_lote']}].");
        }

        if (strtoupper(trim($this->data['documento'])) !== 'FACTURA') {
            throw new RowImportFailedException("La linea [{$this->data['articulo']}] no es una factura. El DOCUMENTO debe ser 'FACTURA'.");
        }

        if ($this->options['updateExisting'] ?? false) {
            $productSaleImport = ProductSaleImport::where([
                'documento'  => $this->data['documento'],
                'codigo'     => $this->data['codigo'],
                'fecha'      => $this->data['fecha'],
                'serie_lote' => $this->data['serie_lote'],
                'articulo'   => $this->data['articulo'],
                'unidades'   => $this->data['unidades'],
            ])->first();

            if ($productSaleImport) {
                throw new RowImportFailedException("La linea [{$this->data['articulo']}] ya se importó anteriormente.");
            }
        }

        return new ProductSaleImport();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        ProductSaleImportCompletedEvent::dispatch();

        $body = 'La importación de ventas de productos se ha completado y se importaron ' . Number::format($import->successful_rows) . ' ' . str('fila')->plural($import->successful_rows) . '.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron/omitieron al importar.';
        }

        return $body;
    }

    public function getJobConnection(): ?string
    {
        return 'sync';
    }
}
