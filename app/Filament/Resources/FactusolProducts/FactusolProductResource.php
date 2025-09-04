<?php

namespace App\Filament\Resources\FactusolProducts;

use App\Filament\Resources\FactusolProducts\Pages\CreateFactusolProduct;
use App\Filament\Resources\FactusolProducts\Pages\EditFactusolProduct;
use App\Filament\Resources\FactusolProducts\Pages\ListFactusolProducts;
use App\Filament\Resources\FactusolProducts\Schemas\FactusolProductForm;
use App\Filament\Resources\FactusolProducts\Tables\FactusolProductsTable;
use App\Models\FactusolProduct;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FactusolProductResource extends Resource
{
    protected static ?string $model = FactusolProduct::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Square3Stack3d;

    protected static string | UnitEnum | null $navigationGroup = 'Factusol';

    public static function getNavigationBadge(): ?string
    {
        return (string) FactusolProduct::count();
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function canGloballySearch(): bool
    {
        return false;
    }

    protected static ?string $label = "Data Factusol";

    protected static ?string $modelLabel = 'Data Factusol';

    protected static ?string $pluralLabel = "Data Factusol";

    protected static ?string $pluralModelLabel = 'Data Factusol';

    protected static ?string $recordTitleAttribute = 'CODART';

    protected static ?bool $shouldSplitGlobalSearchTerms = false;

    public static function form(Schema $schema): Schema
    {
        return FactusolProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FactusolProductsTable::configure($table);
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
            'index' => ListFactusolProducts::route('/'),
            // 'create' => CreateFactusolProduct::route('/create'),
            // 'edit' => EditFactusolProduct::route('/{record}/edit'),
        ];
    }
}
