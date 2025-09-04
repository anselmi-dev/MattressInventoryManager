<?php

namespace App\Filament\Resources\ProductLots\Widgets;

use App\Models\ProductLot;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductLots\Tables\ProductLotsTable;
use App\Filament\Resources\ProductLots\ProductLotResource;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class StockLotsStatuses extends TableWidget
{
    protected int | string | array $columnSpan = [
        'md' => 6,
        'xl' => 3,
    ];

    protected static bool $isLazy = false;

    public function getTableHeading(): ?string
    {
        return false;
    }

    public function table(Table $table): Table
    {
        $productsTable = ProductLotsTable::configure($table);

        $productsTable->getColumn('related_lots_count')->hidden();

        return $productsTable
            ->query(fn (): Builder => ProductLot::query()->latest()->limit(5))
            ->paginated(false)
            ->searchable(false)
            ->filters([])
            ->toolbarActions([
                Action::make('product_lots')->label(__('Lotes recientes'))->link()->url(ProductLotResource::getUrl('index'))->icon(Heroicon::Link),
            ])
            ->headerActions([])
            ->recordActions([]);
    }
}
