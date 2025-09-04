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
use App\Filament\Forms\Components\InfoField;

class ProductLotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                InfoField::make('product_lot_info')
                    ->columnSpanFull()
                    ->hiddenLabel()
                    ->title('El lote debe pertenecer a un producto.')
                    ->description('Un producto puede tener múltiples lotes. La referencia del lote no necesariamente debe ser única para cada producto.'),
                Select::make('reference')
                    ->label(__('Referencia del Producto'))
                    ->relationship(
                        name: 'product',
                        titleAttribute: 'reference',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('name', 'asc')
                    )
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return new HtmlString("<b>{$record->reference}</b> <br> <b>{$record->name}</b>");
                    })
                    ->getSearchResultsUsing(function (string $search): array {
                        return Product::where(function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%")
                                    ->orWhere('reference', 'like', "%{$search}%");
                            })
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn ($record) => [
                                $record->reference => "<b>{$record->reference}</b> <br> <b>{$record->name}</b>",
                            ])
                            ->toArray();
                    })
                    ->afterStateUpdated(function ($state, callable $set, callable $get) use ($schema) {
                        self::hideRelatedLots($schema, $set, $get);
                    })
                    ->afterStateHydrated(function ($state, callable $set, callable $get) use ($schema) {
                        self::hideRelatedLots($schema, $set, $get);
                    })
                    ->columnSpanFull()
                    ->allowHtml()
                    ->reactive()
                    ->searchable()
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
                    ->label(__('Fecha del Lote'))
                    ->default(now())
                    ->columnSpanFull()
                    ->required(),
                Repeater::make('relatedLots')
                    ->relationship()
                    ->label('Partes del Lote')
                    ->reactive()
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
                                        $query->where('name', 'like', "%{$search}%")
                                            ->orWhere('reference', 'like', "%{$search}%")
                                            ->orWhereHas('product', function ($query) use ($search) {
                                                $query->where('products.name', 'like', "%{$search}%")
                                                    ->orWhere('products.reference', 'like', "%{$search}%")
                                                    ->orWhere('products.code', 'like', "%{$search}%");
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
                            ->helperText(function ($state) {
                                if ($state && $productLot = ProductLot::with('product')->find($state)) {
                                    return "El lote '{$productLot->product->name}' tiene un stock de ({$productLot->quantity})";
                                }
                                return null;
                            })
                            ->columnSpan('full')
                    ])
                    ->columnSpan('full')
                    ->columns(2),
            ]);
    }

    /**
     * Hide related lots
     *
     * @param Schema $schema
     * @param callable $set
     * @param callable $get
     * @return void
     */
    protected static function hideRelatedLots (Schema $schema, callable $set, callable $get): void
    {
        // search product by reference and check if it is a combination
        $is_combination = Product::where('reference', $get('reference'))->first()?->is_combination;

        // Hide related lots
        $schema->getComponent('relatedLots')->hidden(fn (): bool => !$is_combination)->required($is_combination ? true : false)->minItems($is_combination ? 1 : 0);

        // Reset related lots
        $set('relatedLots', []);
    }
}
