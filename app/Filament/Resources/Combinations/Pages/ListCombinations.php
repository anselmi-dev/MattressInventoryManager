<?php

namespace App\Filament\Resources\Combinations\Pages;

use App\Filament\Resources\Combinations\CombinationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCombinations extends ListRecords
{
    protected static string $resource = CombinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->slideOver()
                ->modalWidth('xl'),
        ];
    }
}
