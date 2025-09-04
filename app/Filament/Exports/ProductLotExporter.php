<?php

namespace App\Filament\Exports;

use App\Models\ProductLot;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProductLotExporter extends Exporter
{
    protected static ?string $model = ProductLot::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__('filament.resources.id')),
            ExportColumn::make('name')->label(__('filament.resources.name')),
            ExportColumn::make('quantity')->label(__('filament.resources.quantity')),
            ExportColumn::make('reference')->label(__('filament.resources.reference')),
            ExportColumn::make('created_at')->label(__('filament.resources.created_at')),
            ExportColumn::make('updated_at')->label(__('filament.resources.updated_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product lot export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
