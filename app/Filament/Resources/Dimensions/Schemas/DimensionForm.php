<?php

namespace App\Filament\Resources\Dimensions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class DimensionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('filament.resources.code'))
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('height')
                    ->label(__('filament.resources.height'))
                    ->required()
                    ->numeric(),
                TextInput::make('width')
                    ->label(__('filament.resources.width'))
                    ->required()
                    ->numeric(),
                ToggleButtons::make('visible')
                    ->label(__('filament.resources.visible'))
                    ->boolean()
                    ->grouped()
                    ->required(),
                Textarea::make('description')
                    ->label(__('filament.resources.description'))
                    ->columnSpanFull(),
            ]);
    }
}
