<?php

namespace App\Filament\Resources\StockChanges\Pages;

use App\Filament\Resources\StockChanges\StockChangeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockChange extends ViewRecord
{
    protected static string $resource = StockChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
