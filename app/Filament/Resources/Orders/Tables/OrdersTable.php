<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Orders\Actions\OrderReceptionConfirmationAction;
use App\Filament\Resources\Orders\Actions\ConfirmOrderShipmentAction;
use Filament\Support\Icons\Heroicon;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('filament.resources.status'))
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'draft' => 'Borrador',
                        'pending' => 'Pendiente',
                        'processed' => 'Procesado',
                        'shipped' => 'Enviado',
                        'completed' => 'Completada',
                        'canceled' => 'Cancelada',
                        default => $state,
                    }),
                TextColumn::make('order_products_count')
                    ->label(__('filament.resources.products'))
                    ->icon('heroicon-o-shopping-cart')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('filament.resources.created_at'))
                    ->dateTime()
                    ->sortable(),
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
                return $query->withCount('order_products');
            })
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                // ConfirmOrderShipmentAction::make()->label(__('Confirmar envío'))->icon(Heroicon::Truck),
                OrderReceptionConfirmationAction::make()->label(__('Confirmar recepción'))->icon(Heroicon::Truck),
                EditAction::make()->label(__('Ver'))->icon(Heroicon::Eye),
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
