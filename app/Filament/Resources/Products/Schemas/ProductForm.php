<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;

use Filament\Schemas\Schema;
use App\Filament\Resources\Dimensions\Schemas\DimensionForm;
use App\Models\ProductType;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label(__('filament.resources.code'))
                    ->required(),
                TextInput::make('reference')
                    ->label(__('filament.resources.reference'))
                    ->required(),
                TextInput::make('name')
                    ->label(__('filament.resources.name'))
                    ->required(),
                Select::make('type')
                    ->label(__('filament.resources.type'))
                    ->options(fn (): array => ProductType::query()->orderBy('name')->pluck('name', 'name')->all()),
                Select::make('dimension_id')
                    ->label(__('filament.resources.dimension'))
                    ->relationship('dimension', 'code')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(fn (Schema $schema): Schema => DimensionForm::configure($schema)),
                // TextInput::make('stock')
                //     ->label(__('filament.resources.stock'))
                //     ->minValue(0)
                //     ->required()
                //     ->numeric()
                //     ->default(0),
                TextInput::make('minimum_order')
                    ->label(__('filament.resources.minimum_order'))
                    ->minValue(0)
                    ->required()
                    ->numeric()
                    ->default(0),
                ToggleButtons::make('minimum_order_notification_enabled')
                    ->label(__('filament.resources.minimum_order_notification_enabled'))
                    ->boolean()
                    ->grouped()
                    ->required(),
                ToggleButtons::make('visible')
                    ->label(__('filament.resources.visible'))
                    ->boolean()
                    ->grouped()
                    ->required(),
                Textarea::make('description')
                    ->label(__('filament.resources.description'))
                    ->columnSpanFull(),
            ])
            ->columns([
                'sm' => 2,
                'lg' => 3,
                'xl' => 4,
            ]);
    }
}
