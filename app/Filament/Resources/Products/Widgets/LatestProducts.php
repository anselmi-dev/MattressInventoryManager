<?php

namespace App\Filament\Resources\Products\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Product;
use App\Filament\Resources\Products\Tables\ProductsTable;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Products\ProductResource;

class LatestProducts extends TableWidget
{
    protected int | string | array $columnSpan = [
        'md' => 6,
        'xl' => 3,
    ];

    public function getTableHeading(): ?string
    {
        return false;
    }

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        $productsTable = ProductsTable::configure($table);

        $productsTable->getColumn('visible')->hidden();

        $productsTable->getColumn('AVERAGE_SALES')->hidden();

        $productsTable->getColumn('AVERAGE_SALES_PER_DAY')->hidden();

        $productsTable->getColumn('AVERAGE_SALES_DIFFERENCE')->hidden();

        $productsTable->getColumn('minimum_order')->hidden();

        $productsTable->getColumn('minimum_order_notification_enabled')->hidden();

        return $productsTable
            ->query(fn (): Builder => Product::query()->stockOrder()->whereNotCombinations()->averageSalesForLastDays()->latest()->limit(5))
            ->paginated(false)
            ->searchable(false)
            ->filters([])
            ->toolbarActions([
                Action::make('products')->label(__('Productos recientes'))->link()->url(ProductResource::getUrl('index'))->icon(Heroicon::Link),
            ])
            ->headerActions([])
            ->recordActions([]);
    }
}
