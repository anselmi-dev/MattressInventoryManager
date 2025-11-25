<?php

namespace App\Filament\Resources\ProductSales\Pages;

use App\Filament\Resources\ProductSales\ProductSaleResource;
use App\Filament\Exports\ProductSaleExporter;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Sales\Actions\ScanSalesAction;

class ListProductSales extends ListRecords
{
    protected static string $resource = ProductSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ScanSalesAction::make('Sincronizar Ventas'),
            ExportAction::make()
                ->exporter(ProductSaleExporter::class)
                ->label('Exportar')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),
            // CreateAction::make(),
        ];
    }
}
