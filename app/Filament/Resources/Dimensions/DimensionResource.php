<?php

namespace App\Filament\Resources\Dimensions;

use App\Filament\Resources\Dimensions\Pages\CreateDimension;
use App\Filament\Resources\Dimensions\Pages\EditDimension;
use App\Filament\Resources\Dimensions\Pages\ListDimensions;
use App\Filament\Resources\Dimensions\Schemas\DimensionForm;
use App\Filament\Resources\Dimensions\Tables\DimensionsTable;
use App\Models\Dimension;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use UnitEnum;
use App\Filament\Resources\Dimensions\RelationManagers\ProductsRelationManager;

class DimensionResource extends Resource
{
    protected static ?string $model = Dimension::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Swatch;

    protected static string | UnitEnum | null $navigationGroup = 'Configuración';

    protected static ?string $label = "Medidas";

    protected static ?string $modelLabel = 'Medida';

    protected static ?string $pluralLabel = "Medidas";

    protected static ?string $pluralModelLabel = 'Medidas';

    protected static ?string $recordTitleAttribute = 'code';

    public static function getNavigationBadge(): ?string
    {
        return (string) Dimension::count();
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return new HtmlString(
            sprintf(
                '<div>%s <br> <b>%s</b></div>',
                $record->code,
                $record->label
            )
        );
    }

    public static function form(Schema $schema): Schema
    {
        return DimensionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DimensionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDimensions::route('/'),
            // 'create' => CreateDimension::route('/create'),
            // 'edit' => EditDimension::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
