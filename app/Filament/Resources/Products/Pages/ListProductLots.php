<?php

namespace App\Filament\Resources\Products\Pages;

use App\Models\Product;
use App\Models\ProductLot;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\ProductLots\Tables\ProductLotsTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Support\Icons\Heroicon;
class ListProductLots extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.products.pages.list-product-lots';

    public Product $record;

    public function mount(Product $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return 'Lotes de ' . $this->record->name;
    }

    public function table(Table $table): Table
    {
        return ProductLotsTable::configure($table)
            ->query(
                ProductLot::query()->where('reference', $this->record->reference)
            );
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Volver a Productos')
                ->color('gray')
                ->icon(Heroicon::ArrowLeft)
                ->url(fn () => ProductResource::getUrl('index')),
            Action::make('create')
                ->icon(Heroicon::Plus)
                ->label('Nuevo Lote'),
        ];
    }
}
