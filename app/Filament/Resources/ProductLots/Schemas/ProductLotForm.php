<?php

namespace App\Filament\Resources\ProductLots\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;
use App\Models\ProductLot;
use App\Models\Product;

class ProductLotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('reference')
                    ->relationship(
                        name: 'product',
                        titleAttribute: 'reference',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('name', 'asc')
                    )
                    ->label(__('Referencia del Producto'))
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return new HtmlString("<b>{$record->reference}</b> <br> <b>{$record->name}</b>");
                    })
                    ->afterStateUpdated(function ($state, callable $set) use ($schema) {
                        $product = Product::where('reference', $state)->first();

                        if ($product) {
                            $set('relatedLots', []);
                            $schema->getComponent('relatedLots')->hidden(fn (): bool => $product->isCombination);
                        }
                    })
                    ->columnSpanFull()
                    ->allowHtml()
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->label(__('Nombre del Lote'))
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('quantity')
                    ->label(__('filament.resources.quantity') . ' (Opcional)')
                    ->helperText('La cantidad inicial del Lote. Esto no afectará el stock disponible de las partes.')
                    ->minValue(0)
                    ->default(0)
                    ->hidden()
                    ->numeric(),
                DateTimePicker::make('created_at')
                    ->label(__('filament.resources.created_at'))
                    ->default(now())
                    ->required(),
                Repeater::make('relatedLots')
                    ->relationship()
                    ->label('Partes del Lote')
                    ->schema([
                        Select::make('related_product_lot_id')
                            ->label('Lote de parte')
                            ->relationship(
                                name: 'relatedLot',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->whereHas('product', function (Builder $query) {
                                        $query->whereNotCombinations();
                                    })
                                    ->addSelect([
                                        'product_name' => DB::table('products')->whereColumn('product_lots.reference', 'products.reference')->select('products.name')->take(1)
                                    ])
                                    ->whereIsPart()
                                    ->orderBy('name', 'asc')
                            )
                            ->getOptionLabelFromRecordUsing(function (Model $record) {
                                return new HtmlString("<b>{$record->name}</b> <br> <b>{$record->reference}</b> | {$record->product_name}");
                            })
                            ->getOptionLabelUsing(function ($value): ?string {
                                $lot = ProductLot::with('product')
                                    ->whereHas('product', function (Builder $query) {
                                        $query->whereNotCombinations();
                                    })
                                    ->addSelect([
                                        'product_name' => DB::table('products')->whereColumn('product_lots.reference', 'products.reference')->select('products.name')->take(1)
                                    ])->find($value);

                                if ($lot)
                                    return new HtmlString("<b>{$lot->name}</b> <br> <b>{$lot->reference}</b> | {$lot->product_name}");

                                return null;
                            })
                            ->getSearchResultsUsing(function (string $search): array {
                                return ProductLot::where(function ($query) use ($search) {
                                        $query->where('product_lots.name', 'like', "%{$search}%")
                                            ->orWhereHas('product', function ($query) use ($search) {
                                                $query->where('products.name', 'like', "%{$search}%");
                                        });
                                    })
                                    ->whereHas('product', function (Builder $query) {
                                        $query->whereNotCombinations();
                                    })
                                    ->addSelect([
                                        'product_name' => DB::table('products')->whereColumn('product_lots.reference', 'products.reference')->select('products.name')->take(1)
                                    ])
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn ($record) => [
                                        $record->getKey() => "<b>{$record->name}</b> <br> <b>{$record->reference}</b> | {$record->product_name}",
                                    ])
                                    ->toArray();
                            })
                            ->allowHtml()
                            ->searchable()
                            ->preload()
                            ->required()
                            // ->reactive()
                            ->helperText(function ($state) {
                                if ($state && $productLot = ProductLot::with('product')->find($state)) {
                                    return "El lote '{$productLot->product->name}' tiene un stock de ({$productLot->quantity})";
                                }
                                return null;
                            })
                            ->columnSpan('full')
                    ])
                    ->columnSpan('full')
                    ->columns(2)
                    ->minItems(1)
                    ->required(),
            ]);
    }
}
