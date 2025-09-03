<?php

namespace App\Filament\Tables\Actions;

use App\Models\Product;
use App\Models\ProductLot;
use App\Filament\Resources\ProductLots\Schemas\ProductLotForm;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;

class CreateLotAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->label('Crear Lote')
            ->modalHeading('Crear Lote')
            ->modalDescription('Seleccione los datos del lote del producto')
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
                ProductLot::create([
                    'reference' => $record->reference,
                    'name' => $data['name'],
                    'quantity' => $data['quantity'],
                    'created_at' => $data['created_at'] ?? now(),
                ]);
            });
    }
}
