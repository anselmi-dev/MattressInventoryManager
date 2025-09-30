<?php

namespace App\Filament\Resources\StockChanges\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StockChangeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('operation_type'),
                TextEntry::make('old')
                    ->numeric(),
                TextEntry::make('new')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('product_lot.name')
                    ->numeric(),
            ]);
    }
}
