<?php

namespace App\Filament\Resources\ProductSales\Schemas;

use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ProductSaleForm
{
    public static function configure(Schema $schema): Schema
    {
        $record = $schema->getRecord();

        return $schema
            ->components([
                Select::make('sale_id')
                    ->relationship('sale', 'CODFAC')
                    ->disabled(fn ($record) => $record->exists())
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('ARTLFA')
                    ->label(__('filament.resources.ARTLFA'))
                    ->disabled(fn ($record) => $record->exists())
                    ->required(),
                TextInput::make('CANLFA')
                    ->label(__('filament.resources.CANLFA'))
                    ->disabled(fn ($record) => $record->exists())
                    ->required()
                    ->numeric(),
                TextInput::make('TOTLFA')
                    ->label(__('filament.resources.TOTLFA'))
                    ->disabled(fn ($record) => $record->exists())
                    ->required()
                    ->numeric(),
                Select::make('product_lot_id')
                    ->label('Lote')
                    ->relationship(name: 'product_lot', titleAttribute: 'name', modifyQueryUsing: fn (Builder $query) => $query->whereIsPart()->when($record && $record->product, function (Builder $query) use ($record) {
                        $query->where('reference', $record->product->reference);
                    })->orderBy('name', 'asc'))
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return new HtmlString("<b>{$record->name}</b> <br> {$record->product->name}");
                    })
                    ->allowHtml()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->default($record->product_lot_id)
                    ->columnSpanFull()
                    // ->createOptionForm(function ($schema) {
                    //     $schemaProductLot = ProductLotForm::configure($schema);

                    //     $schemaProductLot->fill([
                    //         'reference' => $schema->getOwnerRecord()->reference,
                    //     ]);

                    //     return $schemaProductLot;
                    // })
                    ->required(),
                TextInput::make('DESLFA')
                    ->columnSpanFull()
                    ->disabled(fn ($record) => $record->exists())
                    ->label(__('filament.resources.DESLFA')),
            ]);
    }
}
