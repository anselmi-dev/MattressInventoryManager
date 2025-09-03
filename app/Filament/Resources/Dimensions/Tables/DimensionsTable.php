<?php

namespace App\Filament\Resources\Dimensions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;

class DimensionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('filament.resources.code'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('width')
                    ->label(__('filament.resources.width'))
                    ->numeric()
                    ->suffix('cm')
                    ->sortable(),
                TextColumn::make('height')
                    ->label(__('filament.resources.height'))
                    ->numeric()
                    ->suffix('cm')
                    ->sortable(),
                TextColumn::make('width')
                    ->label(__('filament.resources.width'))
                    ->numeric()
                    ->suffix('cm')
                    ->sortable(),
                TextColumn::make('products_count')
                    ->icon(Heroicon::OutlinedRectangleStack)
                    ->label(__('filament.resources.products'))
                    ->tooltip('Productos que usan esta medida')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('visible')
                    ->label(__('filament.resources.visible'))
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.resources.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label(__('filament.resources.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('filament.resources.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                return $query->withProductCount();
            })
            ->filters([
                TrashedFilter::make(),
                Filter::make('without_products')
                    ->query(fn (Builder $query): Builder => $query->whereDoesntHave('products'))
                    ->label(__('filament.resources.without_products'))
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editar medida')
                    ->slideOver()
                    ->modalWidth('xl')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
