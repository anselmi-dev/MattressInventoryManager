<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Enums\FiltersLayout;
class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('CODFAC')
                    ->label(__('filament.resources.CODFAC'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ESTFAC')
                    ->label(__('filament.resources.ESTFAC'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('CLIFAC')
                    ->label(__('filament.resources.CLIFAC'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('CNOFAC')
                    ->label(__('filament.resources.CNOFAC'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('CEMFAC')
                    ->label(__('filament.resources.CEMFAC'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('TIPFAC')
                    ->label(__('filament.resources.TIPFAC'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('TOTFAC')
                    ->label(__('filament.resources.TOTFAC'))
                    ->sortable()
                    ->prefix('€')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('IREC1FAC')
                    ->label(__('filament.resources.IREC1FAC'))
                    ->sortable()
                    ->prefix('€')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('NET1FAC')
                    ->label(__('filament.resources.NET1FAC'))
                    ->sortable()
                    ->prefix('€')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('IIVA1FAC')
                    ->label(__('filament.resources.IIVA1FAC'))
                    ->sortable()
                    ->prefix('€')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('FECFAC')
                    ->label(__('filament.resources.FECFAC'))
                    ->sortable()
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.resources.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('filament.resources.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('FECFAC', 'desc')
            ->filters([
                Filter::make('FECFAC')
                    ->schema([
                        Section::make()
                            ->label(__('filament.resources.FECFAC'))
                            ->compact()
                            ->columns(2)
                            ->schema([
                                DatePicker::make('FECFAC_from')->hiddenLabel(),
                                DatePicker::make('FECFAC_until')->hiddenLabel(),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['FECFAC_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('FECFAC', '>=', $date),
                            )
                            ->when(
                                $data['FECFAC_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('FECFAC', '<=', $date),
                            );
                    }),
                Filter::make('CNOFAC')
                    ->label(__('filament.resources.CNOFAC'))
                    ->schema([
                        TextInput::make('CNOFAC')
                            ->label(__('filament.resources.CNOFAC'))
                            ->placeholder(__('filament.resources.CNOFAC')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['CNOFAC'],
                                fn (Builder $query, $value): Builder => $query->where('CNOFAC', 'like', "%{$value}%")->orWhere('CLIFAC', 'like', "%{$value}%")->orWhere('CEMFAC', 'like', "%{$value}%"),
                            );
                    }),
            ], layout: FiltersLayout::Dropdown)
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
