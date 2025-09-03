<?php

namespace App\Filament\Resources\ProductLots;

use App\Filament\Resources\ProductLots\Pages\CreateProductLot;
use App\Filament\Resources\ProductLots\Pages\EditProductLot;
use App\Filament\Resources\ProductLots\Pages\ListProductLots;
use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use App\Filament\Resources\ProductLots\Tables\ProductLotsTable;
use App\Models\ProductLot as Model;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductLotResource extends Resource
{
    protected static ?string $model = Model::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $label = "Lotes";

    protected static ?string $modelLabel = 'Lote';

    protected static ?string $pluralLabel = "Lotes";

    protected static ?string $pluralModelLabel = 'Lotes';

    public static function getNavigationBadge(): ?string
    {
        return (string) Model::count();
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ProductLotForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductLotsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductLots::route('/'),
            // 'create' => CreateProductLot::route('/create'),
            // 'edit' => EditProductLot::route('/{record}/edit'),
        ];
    }
}
