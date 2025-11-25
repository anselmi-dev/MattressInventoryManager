<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SaleResource;
use App\Filament\Resources\Sales\Actions\ScanSalesAction;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ScanSalesAction::make('Sincronizar Ventas'),
            // CreateAction::make(),
        ];
    }
}
