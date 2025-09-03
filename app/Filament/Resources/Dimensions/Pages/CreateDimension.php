<?php

namespace App\Filament\Resources\Dimensions\Pages;

use App\Filament\Resources\Dimensions\DimensionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use App\Filament\Resources\Dimensions\Schemas\DimensionForm;

class CreateDimension extends CreateRecord
{
    protected static string $resource = DimensionResource::class;

    public function form(Schema $schema): Schema
    {
        return DimensionForm::configure($schema);
    }
}
