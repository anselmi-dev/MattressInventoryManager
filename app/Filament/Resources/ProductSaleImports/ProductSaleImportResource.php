<?php

namespace App\Filament\Resources\ProductSaleImports;

use App\Filament\Resources\ProductSaleImports\Pages\ListProductSaleImports;
use App\Filament\Resources\ProductSaleImports\Tables\ProductSaleImportsTable;
use App\Models\ProductSaleImport as Model;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ProductSaleImportResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDownTray;

    protected static string | UnitEnum | null $navigationGroup = 'Factusol';

    protected static ?string $label = 'Importación de ventas';

    protected static ?string $pluralLabel = 'Importaciones de ventas';

    protected static ?string $modelLabel = 'Importación de ventas';

    protected static ?string $pluralModelLabel = 'Importaciones de ventas';

    protected static ?string $recordTitleAttribute = 'ID';

    public static function getNavigationBadge(): ?string
    {
        return (string) Model::count();
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function canGloballySearch(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return ProductSaleImportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductSaleImports::route('/'),
        ];
    }
}

