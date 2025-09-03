<?php

namespace App\Filament\Resources\Orders\Actions;

use App\Models\Order;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;

class OrderReceptionConfirmationAction extends Action
{
    public static function make(?string $name = 'order_reception_confirmation'): static
    {
        return parent::make($name)
            ->label(__('Confirmar recepción de la orden'))
            ->visible(fn (Order $record) => $record->getIsShippedAttribute())
            ->modalHeading('Confirmar recepción de la orden')
            ->modalDescription('Ingrese el nombre del lote. Se creará un lote para cada producto.')
            ->color('warning')
            ->slideOver()
            ->modalWidth('xl')
            ->schema(function ($schema, $record) {
                return $schema->components([
                    TextInput::make('name')
                        ->label(__('Nombre del lote'))
                        ->helperText(__('Tener en cuenta que al confirmar la recepción de la orden se creará un lote para cada producto.'))
                        ->required(),
                ]);
            })
            ->modalSubmitActionLabel(__('Confirmar recepción'))
            ->modalCancelActionLabel(__('Cerrar'))
            ->action(function ($data, Order $record) {

                $record->confirmDelivery($data['name']);

                Notification::make()
                    ->title('Success')
                    ->body('La orden ha sido recibida.')
                    ->success()
                    ->send();
            });
    }
}
