<?php

namespace App\Filament\Resources\StockChanges\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockChangeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('quantity')
                    ->label('Cantidad')
                    ->required()
                    ->numeric(),
                Select::make('operation_type')
                    ->options(['add' => 'Add', 'set' => 'Set'])
                    ->label('Tipo de operación')
                    ->default('add')
                    ->required(),
                TextInput::make('old')
                    ->label('Stock anterior')
                    ->required()
                    ->numeric(),
                TextInput::make('new')
                    ->label('Stock nuevo')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->label('Estado')
                    ->options(['pending' => 'Pending', 'processed' => 'Processed'])
                    ->default('pending')
                    ->required(),
                Textarea::make('message')
                    ->label('Mensaje')
                    ->columnSpanFull(),
                Select::make('product_lot_id')
                    ->label('Lote')
                    ->relationship('product_lot', 'name')
                    ->required(),
            ]);
    }
}
