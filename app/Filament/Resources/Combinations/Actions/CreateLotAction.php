<?php

namespace App\Filament\Resources\ProductLots\Actions;

use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use App\Models\Product;
use App\Models\ProductLot;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;

class CreateLotAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->icon(Heroicon::OutlinedPlus)
            ->label('Crear Lote')
            ->modalHeading('Crear Lote')
            ->modalDescription('Seleccione los datos del lote del producto')
            ->color('warning')
            ->schema(function ($schema, $record) {

                $schema = ProductLotForm::configure($schema)->model(ProductLot::class);

                $schema->getComponent('reference')
                    ->searchable(false)
                    ->disabled()
                    ->hidden()
                    ->default($record->reference);

                return $schema;
            })
            ->action(function (array $data, Product $record): void {

                $productLot = ProductLot::create([
                    'reference' => $record->reference,
                    'name' => $data['name'],
                    'quantity' => $data['quantity'],
                    'created_at' => $data['created_at'] ?? now(),
                ]);

                Notification::make()
                    ->title('Lote creado correctamente')
                    ->success()
                    ->send();
            });

    }
}
