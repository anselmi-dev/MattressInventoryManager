<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Filament\Widgets\FactusolProductWarningWidget;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Actions\ActionGroup;
class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
            ActionGroup::make([
                Action::make('sync_factusol')
                    ->label('Ver Stock-Factusol')
                    ->icon('heroicon-o-magnifying-glass')
                    ->action(function() {
                        try {
                            $F_STOC = (new \App\Services\FactusolService())->get_stock($this->record->code);

                            $stock = optional($F_STOC)[4]['dato'];

                            $message = "El product {$this->record->code} posee un stock de {$stock} en Factusol";

                        } catch (\Throwable $th) {

                            report($th);

                            $message = "Error al sincronizar con Factusol";
                        }

                        Notification::make()
                            ->title($message)
                            ->status(fn () => isset($stock) ? 'success' : 'danger')
                            ->send();
                    }),
            ])
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FactusolProductWarningWidget::class,
        ];
    }

    public function getWidgetData(): array
    {
        return [
            'record' => $this->record,
        ];
    }
}
