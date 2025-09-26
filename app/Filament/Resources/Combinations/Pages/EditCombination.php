<?php

namespace App\Filament\Resources\Combinations\Pages;

use App\Filament\Resources\Combinations\CombinationResource;
use App\Filament\Resources\Combinations\Actions\ManufactureAction;
use App\Filament\Resources\Combinations\Actions\CreateLotCombinationAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Actions\ActionGroup;
use App\Filament\Widgets\FactusolProductWarningWidget;
class EditCombination extends EditRecord
{
    protected static string $resource = CombinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ManufactureAction::make(__('Manufacture')),
            // CreateLotCombinationAction::make('productLots'),
            DeleteAction::make(),
            ActionGroup::make([
                Action::make('sync_factusol')
                    ->label('Ver Stock-Factusol')
                    ->icon('heroicon-o-magnifying-glass')
                    ->action(function() {
                        try {
                            $F_ART_STOCK = (new \App\Services\FactusolService())->get_F_ART_STOCK($this->record->code);

                            $stock = optional($F_ART_STOCK)[1]['dato'];

                            $message = "El product {$this->record->code} tiene un stock de {$stock} en Factusol";

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
