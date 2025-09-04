<?php

namespace App\Filament\Resources\ProductLots\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductLots\ProductLotResource;
use App\Filament\Widgets\InfoWidget;
class ListProductLots extends ListRecords
{
    protected static string $resource = ProductLotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver()
                ->modalWidth('xl'),
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
