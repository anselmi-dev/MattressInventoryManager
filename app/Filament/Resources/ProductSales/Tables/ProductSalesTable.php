<?php

namespace App\Filament\Resources\ProductSales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use App\Filament\Resources\ProductSales\Actions\AssociateOfLotAction;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Icons\Heroicon;

class ProductSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sale.CODFAC')
                    ->label(__('filament.resources.sale_CODFAC')),
                TextColumn::make('ARTLFA')
                    ->label(__('filament.resources.ARTLFA'))
                    ->icon(fn ($record) => empty($record->product) ? Heroicon::XCircle : Heroicon::CheckCircle)
                    ->iconColor(fn ($record) => empty($record->product) ? 'danger' : 'success')
                    ->tooltip(fn ($record) => empty($record->product) ? __('filament.resources.product_not_found') : __('filament.resources.product_found'))
                    ->searchable(),
                TextColumn::make('CANLFA')
                    ->label(__('filament.resources.CANLFA'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('TOTLFA')
                    ->label(__('filament.resources.TOTLFA'))
                    ->prefix('€')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('DESLFA')
                    ->label(__('filament.resources.DESLFA'))
                    ->searchable(),
                TextColumn::make('product_lot.name')
                    ->label(__('filament.resources.product_lot_name'))
                    ->searchable(),
                TextColumn::make('processed_at')
                    ->label(__('filament.resources.processed_at'))
                    ->toggleable(isToggledHiddenByDefault: true)
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
            ->defaultGroup('sale_id')
            ->groups([
                Group::make('sale_id')
                    ->collapsible()
                    ->label(__('filament.resources.sale_CODFAC'))->getTitleFromRecordUsing(fn (Model $record): string => ucfirst($record->sale->CODFAC)),
            ])
            ->defaultSort('created_at', 'desc')
            // ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('product'))
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->hidden(fn ($record) => !$record->product_lot_id)
                    ->modalWidth('xl'),
                AssociateOfLotAction::make('Lote')
                    ->hidden(fn ($record) => $record->product_lot_id)
                    ->modalWidth('xl'),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
