<?php

namespace App\Filament\Resources\Combinations\Pages;

use App\Filament\Resources\Combinations\CombinationResource;
use App\Filament\Resources\Combinations\Actions\ManufactureAction;
use App\Filament\Resources\Combinations\Actions\CreateLotCombinationAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditCombination extends EditRecord
{
    protected static string $resource = CombinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ManufactureAction::make(__('Manufacture')),
            // CreateLotCombinationAction::make('productLots'),
            DeleteAction::make(),
        ];
    }
}
