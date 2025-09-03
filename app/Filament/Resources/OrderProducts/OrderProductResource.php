<?php

namespace App\Filament\Resources\OrderProducts;

use App\Filament\Resources\OrderProducts\Pages\CreateOrderProduct;
use App\Filament\Resources\OrderProducts\Pages\EditOrderProduct;
use App\Filament\Resources\OrderProducts\Pages\ListOrderProducts;
use App\Filament\Resources\OrderProducts\Schemas\OrderProductForm;
use App\Filament\Resources\OrderProducts\Tables\OrderProductsTable;
use App\Models\OrderProduct;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrderProductResource extends Resource
{
    protected static ?string $model = OrderProduct::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static string | UnitEnum | null $navigationGroup = 'Ordenes';

    protected static ?string $label = "Ordenes de productos";

    protected static ?string $modelLabel = 'Orden de productos';

    protected static ?string $pluralLabel = "Ordenes de productos";

    protected static ?string $pluralModelLabel = 'Productos';

    protected static ?string $recordTitleAttribute = 'product.name';

    public static function hasNavigation(): bool
    {
        return false;
    }

    public static function canGloballySearch(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return OrderProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrderProductsTable::configure($table);
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
            'index' => ListOrderProducts::route('/'),
            'create' => CreateOrderProduct::route('/create'),
            'edit' => EditOrderProduct::route('/{record}/edit'),
        ];
    }
}
