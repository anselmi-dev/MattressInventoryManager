<?php

namespace App\Filament\Resources\Combinations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\IconColumn;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Combinations\Actions\ManufactureAction;
use App\Filament\Tables\Columns\StockColumn;
use App\Filament\Exports\ProductExporter;
use Filament\Actions\ExportBulkAction;

class CombinationsTable
{
    public static function configure(Table $table): Table
    {
        $days = (int) settings()->get('stock:media:days', 10);

        $stock_days = (int) settings()->get('stock:days', 10);

        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('filament.resources.code'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('filament.resources.name'))
                    ->sortable(),
                TextColumn::make('reference')
                    ->label(__('filament.resources.reference'))
                    ->sortable(),
                IconColumn::make('visible')
                    ->label(__('filament.resources.visible'))
                    ->toggleable()
                    ->boolean()
                    ->sortable(),
                StockColumn::make('STOCK_LOTES')
                    ->label(__('filament.resources.stock'))
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('LOTES_COUNT')
                    ->tooltip('Lotes que posee el Colchón')
                    ->label(__('filament.resources.lotes'))
                    ->toggleable()
                    ->icon(Heroicon::Cube)
                    ->iconPosition(IconPosition::After)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('AVERAGE_SALES')
                    ->label('Total Ventas')
                    ->suffix(' (' . $days . ' días)')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('AVERAGE_SALES_PER_DAY')
                    ->label('Promedio Ventas')
                    ->suffix(' (' . $days . ' días)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('AVERAGE_SALES_DIFFERENCE')
                    ->label('Diferencia (' . $stock_days . ' días)')
                    ->suffix(' x día')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dimension.description')
                    ->label(__('filament.resources.description'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.resources.created_at'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('filament.resources.updated_at'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable([
                'code',
                'name',
                'reference',
            ])
            ->modifyQueryUsing(function (Builder $query) {
                return $query->whereCombinations()->stockOrder()->averageSalesForLastDays();
            })
            ->filters([
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->slideOver()
                        ->modalWidth('xl'),
                    // CreateLotCombinationAction::make('productLots'),
                    ManufactureAction::make(__('Manufacture')),
                    DeleteAction::make(),
                ])->icon('heroicon-m-ellipsis-horizontal')
                ->label('Acciones'),
            ])
            ->toolbarActions([
                ExportBulkAction::make()
                    ->exporter(ProductExporter::class),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
