<?php

namespace App\Filament\Resources\ProductSales;

use App\Filament\Resources\ProductSales\Pages\CreateProductSale;
use App\Filament\Resources\ProductSales\Pages\EditProductSale;
use App\Filament\Resources\ProductSales\Pages\ListProductSales;
use App\Filament\Resources\ProductSales\Schemas\ProductSaleForm;
use App\Filament\Resources\ProductSales\Tables\ProductSalesTable;
use App\Filament\Resources\ProductSales\RelationManagers\SaleRelationManager;
use App\Models\ProductSale;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProductSaleResource extends Resource
{
    protected static ?string $model = ProductSale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Factusol';

    public static function getNavigationBadge(): ?string
    {
        return (string) ProductSale::count();
    }

    public static function canGloballySearch(): bool
    {
        return false;
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    protected static ?string $label = "Facturas de productos";

    protected static ?string $modelLabel = 'Factura de producto';

    protected static ?string $pluralLabel = "Facturas de productos";

    protected static ?string $pluralModelLabel = 'Facturas de productos';

    protected static ?string $recordTitleAttribute = 'ARTLFA';

    public static function form(Schema $schema): Schema
    {
        return ProductSaleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductSalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SaleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductSales::route('/'),
            // 'create' => CreateProductSale::route('/create'),
            // 'edit' => EditProductSale::route('/{record}/edit'),
        ];
    }
}
