<?php

namespace App\Filament\Resources\ProductLots\Pages;

use App\Filament\Resources\ProductLots\ProductLotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

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
}
