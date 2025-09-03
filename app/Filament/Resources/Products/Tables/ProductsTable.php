<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\TextSize;
use App\Filament\Tables\Columns\StockColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\ActionGroup;
use App\Filament\Resources\ProductLots\Actions\CreateLotAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Product;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        $days = (int) settings()->get('stock:media:days', 10);

        $stock_days = (int) settings()->get('stock:days', 10);

        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament.resources.id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric(),
                TextColumn::make('code')
                    ->label(__('filament.resources.code'))
                    ->icon(function ($record) {
                        if ($record->factusolProduct)
                            return Heroicon::CheckCircle;

                        return Heroicon::XCircle;
                    })
                    ->iconColor(function ($record) {
                        if ($record->factusolProduct)
                            return 'success';

                        return 'danger';
                    })
                    ->tooltip(function ($record) {
                        if ($record->factusolProduct)
                            return __('Existe en Factusol');

                        return __('No existe en Factusol');
                    })
                    ->searchable(),
                TextColumn::make('reference')
                    ->label(__('filament.resources.reference'))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('filament.resources.name'))
                    ->searchable(),
                TextColumn::make('type')
                    ->label(__('filament.resources.type'))
                    ->searchable(),
                TextColumn::make('dimension.code')
                    ->label(__('filament.resources.dimension'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('visible')
                    ->label(__('filament.resources.visible'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean()
                    ->sortable(),
                TextColumn::make('stock')
                    ->label(__('Stock (old)'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                StockColumn::make('STOCK_LOTES')
                    ->label(__('filament.resources.stock'))
                    ->sortable(),
                TextColumn::make('LOTES_COUNT')
                    ->label(__('filament.resources.lotes'))
                    ->icon(Heroicon::ClipboardDocumentCheck)
                    ->iconPosition(IconPosition::After)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('AVERAGE_SALES')
                    ->label('Total Ventas')
                    ->suffix(' (' . $days . ' días)')
                    ->sortable(),
                TextColumn::make('AVERAGE_SALES_PER_DAY')
                    ->label('Promedio Ventas')
                    ->suffix(' (' . $days . ' días)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('AVERAGE_SALES_DIFFERENCE')
                    ->label('Diferencia (' . $stock_days . ' días)')
                    ->suffix(' x día')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('minimum_order')
                    ->label(__('filament.resources.minimum_order'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('minimum_order_notification_enabled')
                    ->label(__('filament.resources.notification'))
                    ->boolean(),
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
                TextColumn::make('deleted_at')
                    ->label(__('filament.resources.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->stockOrder()->averageSalesForLastDays();
            })
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('factusolProduct')
                    ->options([
                        'with' => 'Con Factusol',
                        'without' => 'Sin Factusol',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $value = $data['value'] ?? null;

                        if ($value === 'with') {
                            return $query->whereHas('factusolProduct');
                        }
                        if ($value === 'without') {
                            return $query->whereDoesntHave('factusolProduct');
                        }
                        return $query;
                    }),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    CreateLotAction::make('productLots'),
                    Action::make('viewLots')
                        ->label('Ver Lotes')
                        ->icon('heroicon-o-list-bullet')
                        ->url(fn (Product $record): string => ProductResource::getUrl('listLots', ['record' => $record])),
                ])
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
