<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product as Model;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use App\Filament\Resources\Products\Pages\ListProductLots;
use Illuminate\Database\Eloquent\Model as BaseModel;

class ProductResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static string | UnitEnum | null $navigationGroup = 'Productos';

    protected static ?string $label = "Partes";

    protected static ?string $modelLabel = 'Parte';

    protected static ?string $pluralLabel = "Partes";

    protected static ?string $pluralModelLabel = 'Partes';

    protected static ?string $recordTitleAttribute = 'name';

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

    public static function getGloballySearchableAttributes(): array
    {
        return ['code', 'name'];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Model::whereNotCombinations()->count();
    }

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LotsRelationManager::class,
            // RelationManagers\MedidasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
            'listLots' => ListProductLots::route('/{record}/listLots'),
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
