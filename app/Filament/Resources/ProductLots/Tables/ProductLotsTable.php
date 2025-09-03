<?php

namespace App\Filament\Resources\ProductLots\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use App\Models\ProductLot;

class ProductLotsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.resources.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reference')
                    ->label(__('filament.resources.reference'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label(__('filament.resources.product'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.productType.name')
                    ->label(__('filament.resources.type'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label(__('filament.resources.quantity'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('related_lots_count')
                    ->label('Total de Lotes de partes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.resources.created_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('filament.resources.updated_at'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                return $query->withCount('relatedLots');
            })
            ->filters([
                Filter::make('search')
                    ->schema([
                        TextInput::make('search')
                            ->label(__('filament.resources.product')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['search'],
                                fn (Builder $query, $value): Builder => $query->where('reference', 'like', "%{$value}%")
                                    ->orWhereHas('product', function (Builder $query) use ($value) {
                                        $query->where('name', 'like', "%{$value}%");
                                    })
                            );
                    }),
                Filter::make('has_quantity')
                    ->schema([
                        Select::make('has_quantity')
                            ->options([
                                'all' => 'Todos',
                                '1' => 'Sí',
                                '0' => 'No',
                            ])
                            ->label(__('filament.resources.has_quantity'))
                            ->default(fn(): string => 'all'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['has_quantity'] == '1',
                            fn (Builder $query): Builder => $query->where('quantity', '>', 0),
                        )->when(
                            $data['has_quantity'] == '0',
                            fn (Builder $query): Builder => $query->where('quantity', '<=', 0),
                        );
                    }),

                Filter::make('created_at')
                    ->schema([
                        Section::make()
                            ->label(__('filament.resources.created_at'))
                            ->compact()
                            ->columns(2)
                            ->schema([
                                DatePicker::make('created_at_from')->hiddenLabel(),
                                DatePicker::make('created_at_until')->hiddenLabel(),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_at_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_at_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->modalWidth('xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
