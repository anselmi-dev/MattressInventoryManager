<?php

namespace App\Filament\Resources\FactusolProducts\Pages;

use App\Filament\Resources\FactusolProducts\FactusolProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFactusolProduct extends EditRecord
{
    protected static string $resource = FactusolProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
