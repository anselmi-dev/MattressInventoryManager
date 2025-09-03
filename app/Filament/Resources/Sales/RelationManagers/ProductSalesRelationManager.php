<?php

namespace App\Filament\Resources\Sales\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use App\Filament\Resources\ProductSales\ProductSaleResource;
use App\Filament\Resources\ProductSales\Tables\ProductSalesTable;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\ProductSales\Schemas\ProductSaleForm;
use Filament\Schemas\Schema;

class ProductSalesRelationManager extends RelationManager
{
    protected static string $relationship = 'product_sales';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return ProductSaleResource::getPluralModelLabel();
    }

    public function table(Table $table): Table
    {
        return ProductSalesTable::configure($table);
    }

    public function form(Schema $schema): Schema
    {
        return ProductSaleForm::configure($schema);
    }
}
