<?php

namespace App\Filament\Resources\Combinations;

use App\Filament\Resources\Combinations\Pages\CreateCombination;
use App\Filament\Resources\Combinations\Pages\EditCombination;
use App\Filament\Resources\Combinations\Pages\ListCombinations;
use App\Filament\Resources\Combinations\Schemas\CombinationForm;
use App\Filament\Resources\Combinations\Tables\CombinationsTable;
use App\Models\Product as Model;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\HtmlString;
use App\Filament\Resources\Combinations\RelationManagers;
use Illuminate\Database\Eloquent\Builder;

class CombinationResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBoxArrowDown;

    protected static ?string $label = "Colchones";

    protected static ?string $modelLabel = 'Colchón';

    protected static ?string $pluralLabel = "Colchones";

    protected static ?string $pluralModelLabel = 'Colchones';

    public static function getNavigationBadge(): ?string
    {
        return (string) Model::whereCombinations()->count();
    }

    public static function getGlobalSearchResultTitle(BaseModel $record): string | Htmlable
    {
        return new HtmlString(
            sprintf(
                '<div>%s <br> <b>%s</b></div>',
                $record->code,
                $record->name,
            )
        );
    }

    public static function getGlobalSearchResultsLimit(): int
    {
        return 3;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'name'];
    }

    public static function form(Schema $schema): Schema
    {
        return CombinationForm::configure($schema);

    }

    public static function table(Table $table): Table
    {
        return CombinationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LotsRelationManager::class,
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return static::getEloquentQuery()->whereCombinations();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCombinations::route('/'),
            'create' => CreateCombination::route('/create'),
            'edit' => EditCombination::route('/{record}/edit'),
        ];
    }
}
