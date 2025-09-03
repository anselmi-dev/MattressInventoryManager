<?php

namespace App\Filament\Resources\OrderProducts\Schemas;

use App\DataTypes\StatusOrderProductDataType;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->label('Producto')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('order_id')
                    ->label('#Orden')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->label('Estado')
                    ->options([
                        StatusOrderProductDataType::PENDING => 'Pendiente',
                        StatusOrderProductDataType::PROCESSED => 'Procesado',
                        StatusOrderProductDataType::CANCELLED => 'Cancelado',
                    ])
                    ->default(StatusOrderProductDataType::PENDING)
                    ->required(),
                TextInput::make('quantity')
                    ->label('Cantidad')
                    ->required()
                    ->numeric(),
                TextInput::make('return')
                    ->label('Devuelto')
                    ->required()
                    ->numeric()
                    ->default(0),
                KeyValue::make('attribute_data')
                        ->columnSpanFull()
            ]);
    }
}
