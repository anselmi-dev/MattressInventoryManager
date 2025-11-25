<?php

namespace App\Filament\Resources\ProductLots\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductLots\ProductLotResource;
use App\Filament\Widgets\InfoWidget;
use App\Filament\Exports\ProductLotExporter;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\Action;

class ListProductLots extends ListRecords
{
    protected static string $resource = ProductLotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver()
                ->modalWidth('xl'),
            ExportAction::make()
                ->exporter(ProductLotExporter::class)
                ->label('Exportar')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InfoWidget::make([
                'description' => '
                    Este listado muestra todos los lotes registrados en el sistema, tanto de partes como de colchones. Cada lote corresponde a un producto (ya sea una parte o un colchón) y cuenta con un stock asociado.
                '
            ]),
        ];
    }
}
