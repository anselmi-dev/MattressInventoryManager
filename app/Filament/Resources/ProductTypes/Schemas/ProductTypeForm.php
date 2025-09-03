<?php

namespace App\Filament\Resources\ProductTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('filament.resources.name'))
                    ->maxLength(255)
                    ->required(),
                Toggle::make('part')
                    ->label(__('filament.resources.part'))
                    ->inlineLabel(false)
                    ->required(),
                TextInput::make('contains')
                    ->label(__('filament.resources.contains'))
                    ->maxLength(255)
                    ->required()
                    ->default(null),
            ]);
    }
}
