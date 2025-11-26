<?php

namespace App\Filament\Resources\ProductSaleImports\Pages;

use App\Filament\Resources\ProductSaleImports\ProductSaleImportResource;
use App\Filament\Imports\ProductSaleImportImporter;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Artisan;
use App\Models\ProductSaleImport;
use Filament\Notifications\Notification;
class ListProductSaleImports extends ListRecords
{
    protected static string $resource = ProductSaleImportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Procesar Pendientes')
                ->label(fn () => ProductSaleImport::whereStatusPending()->exists() ? 'Procesar Pendientes' : 'No existen registros pendientes')
                ->icon(fn () => ProductSaleImport::whereStatusPending()->exists() ? 'heroicon-o-arrow-path' : 'heroicon-o-exclamation-triangle')
                ->color(fn () => ProductSaleImport::whereStatusPending()->exists() ? 'primary' : 'black')
                ->action(function () {
                    if (!ProductSaleImport::whereStatusPending()->exists()) {
                        Notification::make()
                            ->title('No existen registros pendientes')
                            ->danger()
                            ->send();
                    } else {
                        Artisan::call('app:process-pending-product-sale-imports');
                    }
                }),
            ImportAction::make()
                ->importer(ProductSaleImportImporter::class)
                ->label('Importar')
                ->icon('heroicon-o-arrow-up-tray')
                ->options([
                    'updateExisting' => TRUE,
                ])
        ];
    }
}

