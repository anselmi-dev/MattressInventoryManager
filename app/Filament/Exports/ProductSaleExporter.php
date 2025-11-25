<?php

namespace App\Filament\Exports;

use App\Models\ProductSale;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProductSaleExporter extends Exporter
{
    protected static ?string $model = ProductSale::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__('filament.resources.id')),
            ExportColumn::make('sale.CODFAC')
                ->label(__('filament.resources.sale_CODFAC')),
            ExportColumn::make('ARTLFA')
                ->label(__('filament.resources.ARTLFA')),
            ExportColumn::make('CANLFA')
                ->label(__('filament.resources.CANLFA')),
            ExportColumn::make('TOTLFA')
                ->label(__('filament.resources.TOTLFA')),
            ExportColumn::make('DESLFA')
                ->label(__('filament.resources.DESLFA')),
            ExportColumn::make('product.name')
                ->label('Producto'),
            ExportColumn::make('product_lot.name')
                ->label(__('filament.resources.product_lot_name')),
            ExportColumn::make('processed_at')
                ->label(__('filament.resources.processed_at')),
            ExportColumn::make('created_at')
                ->label(__('filament.resources.created_at')),
            ExportColumn::make('updated_at')
                ->label(__('filament.resources.updated_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'La exportación de facturas de productos se ha completado y ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . ' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallaron al exportar.';
        }

        return $body;
    }
}

