<?php

namespace App\Filament\Resources\ProductLots\Pages;

use App\Filament\Resources\ProductLots\ProductLotResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductLot extends EditRecord
{
    protected static string $resource = ProductLotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
