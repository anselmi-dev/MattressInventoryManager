<?php

namespace App\Filament\Resources\Combinations\Pages;

use App\Filament\Resources\Combinations\CombinationResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreateCombination extends CreateRecord
{
    protected static string $resource = CombinationResource::class;

    public function form(Schema $schema): Schema
    {
        $schema = static::getResource()::form($schema);

        // $schema->getComponent('type')->default('COLCHON');

        return $schema;
    }
}
