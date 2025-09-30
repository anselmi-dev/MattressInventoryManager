<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SaleResource;
use App\Services\FactusolService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use App\Services\FactusolSaleService;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            // $this->getSaveFormAction(),
            // $this->getCancelFormAction(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('getFactusolSale')
                ->label("Ver datos de Factusol")
                ->modalHeading("Información de la Factura en Factusol #{$this->record->CODFAC}")
                ->icon('heroicon-o-magnifying-glass')
                ->color('info')
                ->modalContent(function () {
                    try {
                        $response = (new FactusolService())->getSale(code: $this->record->CODFAC);

                        $data = collect($response)->map(function ($item) {
                            return $this->reduceFactusol($item);
                        });

                        return view('filament.components.factusol-data', [
                            'data' => $data,
                            'hasErrors' => $this->hasErrors($data),
                        ]);
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error al consultar Factusol')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }

                    return view('filament.components.no-data');
                })
                 ->action(function () {
                     try {

                         (new FactusolSaleService())->setModel($this->record)->repairProductsSales();

                         Notification::make()
                             ->title('Facturas de productos reparadas')
                                 ->body('Las facturas de productos se han reparado correctamente')
                                 ->success()
                                 ->send();

                         $this->record->refresh();

                        $this->dispatch('refreshRelation');

                     } catch (\Exception $e) {
                         Notification::make()
                             ->title('Error al reparar facturas de productos')
                             ->body($e->getMessage())
                             ->danger()
                             ->send();
                     }
                 })
                ->slideOver(),
            DeleteAction::make(),
        ];
    }

    public function reduceFactusol(array $item): object
    {
        return (object) array_reduce($item, function ($carry, $row) {
            $carry[$row->columna] = $row->dato;
            return $carry;
        }, []);
    }

    protected function hasErrors(Collection $data): bool
    {
        return $this->record->product_sales()->pluck('ARTLFA')->toArray() !== $data->pluck('ARTLFA')->toArray();
    }
}
