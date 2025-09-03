<?php

namespace App\Filament\Resources\ProductSales\RelationManagers;

use App\Filament\Resources\Sales\SaleResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SaleRelationManager extends RelationManager
{
    protected static string $relationship = 'sale';

    protected static ?string $relatedResource = SaleResource::class;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return SaleResource::getModelLabel();
    }

    public function table(Table $table): Table
    {
        return $table->searchable(false)->selectable(false);
    }
}
