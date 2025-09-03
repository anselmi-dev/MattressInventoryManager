<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Models\Order;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ConfirmOrderShipmentAction extends Action
{
    public static function make(?string $name = 'confirm_shipment'): static
    {
        return parent::make($name)
            ->label(__('Confirmar envío'))
            ->visible(fn (Order $record) => $record->getIsPendingAttribute())
            ->modalSubmitActionLabel(__('Confirmar envío'))
            ->modalCancelActionLabel(__('Cerrar'))
            // ->schema(function ($schema, Order $record) {
            //     return OrderForm::configure($schema)
            //         ->fill($record->toArray())
            //         ->model($record);
            // })
            ->action(function (Order $record) {
                try {
                    $record->sendEmail();

                    Notification::make()
                        ->title('¡Éxito!')
                        ->body('El envío ha sido confirmado correctamente.')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title('Error')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();

                    $this->failure();
                }
            });
    }
}
