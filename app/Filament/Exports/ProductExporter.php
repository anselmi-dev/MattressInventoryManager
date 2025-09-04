<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__('filament.resources.id')),
            ExportColumn::make('code')->label(__('filament.resources.code')),
            ExportColumn::make('reference')->label(__('filament.resources.reference')),
            ExportColumn::make('name')->label(__('filament.resources.name')),
            ExportColumn::make('type')->label(__('filament.resources.type')),
            ExportColumn::make('dimension.code')->label(__('filament.resources.dimension')),
            ExportColumn::make('visible')->label(__('filament.resources.visible')),
            ExportColumn::make('stock')->label(__('filament.resources.stock')),
            ExportColumn::make('minimum_order')->label(__('filament.resources.minimum_order')),
            ExportColumn::make('minimum_order_notification_enabled')->label(__('filament.resources.minimum_order_notification_enabled')),
            ExportColumn::make('description')->label(__('filament.resources.description')),
            ExportColumn::make('created_at')->label(__('filament.resources.created_at')),
            ExportColumn::make('updated_at')->label(__('filament.resources.updated_at')),
            ExportColumn::make('deleted_at')->label(__('filament.resources.deleted_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
