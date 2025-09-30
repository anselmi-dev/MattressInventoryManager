<?php

namespace App\Filament\Resources\StockChanges;

use App\Filament\Resources\StockChanges\Pages\CreateStockChange;
use App\Filament\Resources\StockChanges\Pages\EditStockChange;
use App\Filament\Resources\StockChanges\Pages\ListStockChanges;
use App\Filament\Resources\StockChanges\Pages\ViewStockChange;
use App\Filament\Resources\StockChanges\Schemas\StockChangeForm;
use App\Filament\Resources\StockChanges\Schemas\StockChangeInfolist;
use App\Filament\Resources\StockChanges\Tables\StockChangesTable;
use App\Models\StockChange;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StockChangeResource extends Resource
{
    protected static ?string $model = StockChange::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clock;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $label = "Historial de stock";

    protected static ?string $modelLabel = 'Historial de stock';

    protected static ?string $pluralLabel = "Historial de stock";

    protected static ?string $pluralModelLabel = 'Historial de stock';

    public static function canGloballySearch(): bool
    {
        return false;
    }

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function form(Schema $schema): Schema
    {
        return StockChangeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockChangeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockChangesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStockChanges::route('/'),
            'view' => ViewStockChange::route('/{record}'),
        ];
    }
}
