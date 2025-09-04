<?php

namespace App\Filament\Resources\ProductLots;

use App\Filament\Resources\ProductLots\Pages\ListProductLots;
use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use App\Filament\Resources\ProductLots\Tables\ProductLotsTable;
use App\Models\ProductLot as Model;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\HtmlString;

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

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getGlobalSearchResultTitle(BaseModel $record): string | Htmlable
    {
        return new HtmlString(
            sprintf(
                '<div>%s <br> <b>%s</b></div>',
                $record->name,
                $record->reference,
            )
        );
    }

    public static function getGlobalSearchResultsLimit(): int
    {
        return 3;
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
