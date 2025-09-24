<?php

namespace App\Filament\Resources\Combinations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Models\ProductType;

class CombinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(false)
                    ->description(false)
                    ->schema([
                        TextInput::make('code')
                            ->label(__('filament.resources.code'))
                            ->belowContent('El código del producto debe ser único y no puede repetirse en el sistema.')
                            ->maxLength(255)
                            ->unique()
                            ->required(),
                        TextInput::make('name')
                            ->label(__('filament.resources.name'))
                            ->maxLength(255)
                            ->required(),
                        // TextInput::make('stock')
                        //     ->label(__('filament.resources.stock'))
                        //     ->belowContent('Al agregar un stock, la cantidad especificada se descontará automáticamente de las piezas disponibles en esta combinación.')
                        //     ->numeric()
                        //     ->required(),
                        TextInput::make('type')
                            ->label(__('filament.resources.type'))
                            ->readOnly()
                            // ->default(fn (): ?string => ProductType::query()->where('part', true)->first()?->name),
                            ->default('COLCHON'),
                        TextInput::make('reference')
                            ->label(__('filament.resources.reference') . " (Factusol) ")
                            ->belowContent('Representa el código único que se almacena en Factusol como EANART.')
                            ->unique()
                            ->required(),
                        Select::make('dimension_id')
                            ->relationship(name: 'dimension', titleAttribute: 'code')
                            ->searchable(['code'])
                            ->label(__('filament.resources.dimension'))
                            ->preload()
                            ->required(),
                        TextInput::make('description')
                            ->label(__('filament.resources.description'))
                            ->maxLength(255),
                    ])
                    ->columns([
                        'sm' => 2,
                        'lg' => 3,
                        'xl' => 4,
                    ])
                    ->columnSpanFull()
            ]);
    }
}
