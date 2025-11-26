<?php

namespace App\Filament\Resources\ProductSaleImports\Tables;

use App\Models\ProductSaleImport;
use Boquizo\FilamentLogViewer\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Filament\Actions\ActionGroup;
class ProductSaleImportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament.resources.id'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: app()->isProduction()),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn(string $state, ProductSaleImport $record): string => $record->status_label)
                    ->color(fn($record) => match ($record->status) {
                        ProductSaleImport::STATUS_PENDING => 'warning',
                        ProductSaleImport::STATUS_PROCESSING => 'info',
                        ProductSaleImport::STATUS_PROCESSED => 'success',
                        ProductSaleImport::STATUS_ERROR => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('documento')
                    ->label('Documento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('codigo')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('prov_cli')
                    ->label('Prov/Cli')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('serie_lote')
                    ->label('Serie/Lote')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('articulo')
                    ->label('Artículo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unidades')
                    ->label('Unidades')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fabr_env')
                    ->label('Fabr/Env')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('cons_pref')
                    ->label('Cons.pref.')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
            ->filters([
                SelectFilter::make('status')
                    ->options(ProductSaleImport::STATUS_OPTIONS)
                    ->label('Estado')
                    ->native(false),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('process')
                    ->label('Procesar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->visible(fn (ProductSaleImport $record): bool => $record->status === ProductSaleImport::STATUS_PENDING)
                    ->requiresConfirmation()
                    ->modalHeading('Procesar Importación')
                    ->modalDescription('¿Estás seguro de que deseas procesar esta importación?')
                    ->modalSubmitActionLabel('Procesar')
                    ->action(function (ProductSaleImport $record) {
                        try {

                            $record->runProcess();

                            Notification::make()
                                ->title('Importación procesada correctamente')
                                ->body('La importación ' . $record->id . ' se ha procesado correctamente')
                                ->success()
                                ->send();

                            $record->refresh();

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error al procesar')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25);
    }
}
