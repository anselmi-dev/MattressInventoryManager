<?php

namespace App\Filament\Resources\StockChanges\Pages;

use App\Filament\Resources\StockChanges\StockChangeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStockChange extends EditRecord
{
    protected static string $resource = StockChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
