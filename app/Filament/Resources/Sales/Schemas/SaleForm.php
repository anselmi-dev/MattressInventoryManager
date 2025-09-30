<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('CODFAC')
                    ->label(__('filament.resources.CODFAC'))
                    ->required(),
                TextInput::make('ESTFAC')
                    ->label(__('filament.resources.ESTFAC'))
                    ->required(),
                TextInput::make('CLIFAC')
                    ->label(__('filament.resources.CLIFAC')),
                TextInput::make('CNOFAC')
                    ->label(__('filament.resources.CNOFAC')),
                TextInput::make('CEMFAC')
                    ->label(__('filament.resources.CEMFAC')),
                TextInput::make('TIPFAC')
                    ->label(__('filament.resources.TIPFAC')),
                TextInput::make('TOTFAC')
                    ->label(__('filament.resources.TOTFAC'))
                    ->required()
                    ->numeric(),
                TextInput::make('IREC1FAC')
                    ->label(__('filament.resources.IREC1FAC'))
                    ->required()
                    ->numeric(),
                TextInput::make('NET1FAC')
                    ->label(__('filament.resources.NET1FAC'))
                    ->required()
                    ->numeric(),
                TextInput::make('IIVA1FAC')
                    ->label(__('filament.resources.IIVA1FAC'))
                    ->required()
                    ->numeric(),
                DateTimePicker::make('FECFAC')
                    ->label(__('filament.resources.FECFAC'))
                    ->required(),
            ])
            ->columns([
                'sm' => 2,
                'lg' => 3,
                'xl' => 4,
            ]);
    }
}
