<?php

namespace App\Filament\Resources\StockChanges\Pages;

use App\Filament\Resources\StockChanges\StockChangeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockChanges extends ListRecords
{
    protected static string $resource = StockChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
