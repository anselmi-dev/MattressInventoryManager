<?php

namespace App\Filament\Resources\OrderProducts\Pages;

use App\Filament\Resources\OrderProducts\OrderProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrderProduct extends EditRecord
{
    protected static string $resource = OrderProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
