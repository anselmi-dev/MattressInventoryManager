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
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('filament.resources.id'))
                    ->hidden(fn ($record) => app()->isProduction()),
                TextColumn::make('sale.CODFAC')
                    ->sortable()
                    ->label(__('filament.resources.sale_CODFAC')),
                TextColumn::make('ARTLFA')
                    ->sortable()
                    ->label(__('filament.resources.ARTLFA'))
                    ->icon(fn ($record) => empty($record->product) || $record->product->trashed() ? Heroicon::XCircle : Heroicon::CheckCircle)
                    ->iconColor(fn ($record) => empty($record->product) ? 'danger' : ($record->product->trashed() ? 'warning' : 'success'))
                    ->tooltip(fn ($record) => empty($record->product) ? __('filament.resources.product_not_found') : ($record->product->trashed() ? __('filament.resources.product_trashed') : __('filament.resources.product_found')))
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
                    ->icon(fn ($record) => empty($record->product_lot_id) ? Heroicon::XCircle : Heroicon::CheckCircle)
                    ->iconColor(fn ($record) => empty($record->product_lot_id) ? 'danger' : 'success')
                    ->sortable()
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
            ->defaultGroup('sale')
            ->groupingDirectionSettingHidden()
            ->groups([
                Group::make('sale')
                    ->label('Factura')
                    ->collapsible()
                    ->orderQueryUsing(fn (Builder $query) => $query->orderBy('sale_id', 'desc'))
                    ->getTitleFromRecordUsing(fn (Model $record): string => "#" . ucfirst($record->sale->CODFAC) . " | Cliente: " . ucfirst($record->sale->CNOFAC))
                    ->getDescriptionFromRecordUsing(fn (Model $record): string => "€" . ucfirst($record->sale->TOTFAC)),
            ])
            ->defaultSort('created_at', 'desc')
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
