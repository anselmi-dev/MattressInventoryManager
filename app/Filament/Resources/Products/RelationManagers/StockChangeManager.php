<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use App\Filament\Resources\StockChanges\Schemas\StockChangeForm;
use App\Filament\Resources\StockChanges\Tables\StockChangesTable;
use App\Filament\Resources\StockChanges\StockChangeResource;
use Illuminate\Database\Eloquent\Model;

class StockChangeManager extends RelationManager
{
    protected static string $relationship = 'stock_changes';

    protected $listeners = ['refreshRelation' => '$refresh'];

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return StockChangeResource::getPluralModelLabel();
    }

    public function form(Schema $schema): Schema
    {
        return StockChangeForm::configure($schema)->columns(1);
    }

    public function table(Table $table): Table
    {
        return StockChangesTable::configure($table);
    }
}
