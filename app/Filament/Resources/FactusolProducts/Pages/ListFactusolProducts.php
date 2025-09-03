<?php

namespace App\Filament\Resources\FactusolProducts\Pages;

use App\Filament\Resources\FactusolProducts\FactusolProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFactusolProducts extends ListRecords
{
    protected static string $resource = FactusolProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
