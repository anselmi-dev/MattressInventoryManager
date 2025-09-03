<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\Dimensions\Schemas\DimensionForm;
use App\Filament\Resources\Dimensions\Tables\DimensionsTable;
use App\Filament\Resources\Dimensions\DimensionResource;
use Illuminate\Database\Eloquent\Model;

class MedidasRelationManager extends RelationManager
{
    protected static string $relationship = 'dimension';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return DimensionResource::getPluralModelLabel();
    }

    public function form(Schema $schema): Schema
    {
        return DimensionForm::configure($schema)->columns(1);
    }

    public function table(Table $table): Table
    {
        return DimensionsTable::configure($table);
    }
}
