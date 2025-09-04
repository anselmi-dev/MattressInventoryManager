<?php

namespace App\Filament\Exports;

use App\Models\Dimension;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class DimensionExporter extends Exporter
{
    protected static ?string $model = Dimension::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__('filament.resources.id')),
            ExportColumn::make('code')->label(__('filament.resources.code')),
            ExportColumn::make('height')->label(__('filament.resources.height')),
            ExportColumn::make('width')->label(__('filament.resources.width')),
            ExportColumn::make('visible')->label(__('filament.resources.visible')),
            ExportColumn::make('description')->label(__('filament.resources.description')),
            ExportColumn::make('created_at')->label(__('filament.resources.created_at')),
            ExportColumn::make('updated_at')->label(__('filament.resources.updated_at')),
            ExportColumn::make('deleted_at')->label(__('filament.resources.deleted_at')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your dimension export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
