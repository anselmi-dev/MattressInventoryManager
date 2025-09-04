<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\Pages\ListSales;
use App\Filament\Resources\Sales\Pages\EditSale;
use App\Filament\Resources\Sales\Schemas\SaleForm;
use App\Filament\Resources\Sales\Tables\SalesTable;
use App\Models\Sale as Model;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\Sales\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\Sales\RelationManagers\ProductSalesRelationManager;
use UnitEnum;

class SaleResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ReceiptPercent;

    protected static string | UnitEnum | null $navigationGroup = 'Factusol';

    protected static ?string $label = "Facturas";

    protected static ?string $modelLabel = 'Factura';

    protected static ?string $pluralLabel = "Facturas";

    protected static ?string $pluralModelLabel = 'Facturas';

    protected static ?string $recordTitleAttribute = 'CODFAC';

    public static function getNavigationBadge(): ?string
    {
        return (string) Model::count();
    }

    public static function getNavigationSort(): ?int
    {
        return 0;
    }

    public static function canGloballySearch(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return SaleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProductSalesRelationManager::class,
            // ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSales::route('/'),
            // 'create' => CreateSale::route('/create'),
            'edit' => EditSale::route('/{record}/edit'),
        ];
    }
}
