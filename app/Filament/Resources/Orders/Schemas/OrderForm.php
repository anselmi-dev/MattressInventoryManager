<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Repeater::make('order_products')
                            ->label('Productos del pedido')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label(__('filament.resources.product'))
                                    ->relationship(
                                        name: 'product',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query->withoutGlobalScopes()->withTrashed()
                                    )
                                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                                        return new HtmlString("<b>{$record->code}</b> <br> <b>{$record->name}</b>");
                                    })
                                    ->allowHtml()
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('quantity')
                                    ->label(__('filament.resources.quantity'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->required(),
                            ])
                            ->addActionLabel('Agregar Producto')
                            ->reactive()
                            ->afterStateUpdated(function ($component, $state, callable $set) {

                                $products = collect($state)->filter(function ($product) {
                                    return $product['quantity'] !== null && $product['product_id'] !== null;
                                })->map(function ($item) {

                                    $product = Product::withoutGlobalScopes()->where('id', $item['product_id'])->select('name', 'code')->first();

                                    return (object) [
                                        'code' => $product->code,
                                        'name' => $product->name,
                                        'quantity' => $item['quantity'],
                                    ];
                                });

                                $set('message', view('livewire.orders.template-email', [
                                    'products' => $products
                                ])->render());
                            })
                            ->minItems(1)
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),

                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->label(__('Email'))
                            ->required()
                            ->helperText(__('Destinatario de la solicitud.'))
                            ->email()
                            ->default(settings()->get('order:email')),

                        RichEditor::make('message')
                            ->label(__('Mensaje'))
                            ->required()
                            ->columnSpanFull(),
                ]),
            ])
            ->columns([
                'sm' => 1,
                'md' => 1,
                'lg' => 1,
            ]);
    }
}
