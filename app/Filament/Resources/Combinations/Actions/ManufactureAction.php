<?php

namespace App\Filament\Resources\Combinations\Actions;

use App\Models\Product;
use App\Filament\Resources\Combinations\Schemas\ManufactureForm;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Forms\Components\CombinationsSelectLot;
use App\Models\ProductLot;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;


class ManufactureAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->icon('heroicon-o-plus')
            ->before(function (array $data, Product $record, $form, Action $action) {
                try {
                    $exists = ProductLot::where('id', $data['lots'])
                        ->whereHas('relatedLots', function (Builder $query) use ($data) {
                            $query->whereHas('relatedLot', function (Builder $query) use ($data) {
                                $query->orderBy('quantity', 'asc');
                            })->whereHas('relatedLot', function (Builder $query) use ($data) {
                                $query->where('quantity', '<', $data['quantity']);
                            });
                        })->first();

                    if ($exists) {
                        throw new \Exception('La cantidad a fabricar supera el stock disponible de la parte ' . $exists->relatedLots->first()->relatedLot->name . ' | ' . $exists->relatedLots->first()->relatedLot->product->reference);
                    }
                } catch (\Exception $e) {

                    Notification::make()
                        ->title($e->getMessage())
                        ->danger()
                        ->send();

                    $action->halt();
                }
            })
            ->action(function (array $data, \Livewire\Component $livewire) {

                $productLot = ProductLot::find($data['lots']);

                if (!$productLot) {
                    Notification::make()
                        ->title('El lote no existe')
                        ->danger()
                        ->send();

                    return;
                }

                $productLot->manufactureLot($data['quantity'], $data['decrementStock'] ?? true);

                Notification::make()
                    ->title('Fabricación exitosa')
                    ->success()
                    ->send();

                $livewire->dispatch('refreshRelation');
            })
            ->schema(function ($schema, $record) {
                return $schema
                    ->model(Product::class)
                    ->components([
                        Select::make('lots')
                            ->label("Lotes asociados a {$record->reference}")
                            ->relationship(
                                name: 'lots',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('reference', $record->reference)->orderBy('name', 'asc')
                            )
                            ->getOptionLabelFromRecordUsing(function (Model $record) {
                                return new HtmlString("<b>{$record->reference}</b> <br> <i>{$record->name}</i>");
                            })
                            ->allowHtml()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, Schema $schema) {
                                if ($state) {
                                }
                            })
                            ->preload()
                            ->required(),

                        CombinationsSelectLot::make('lot')
                            ->label('Partes asociadas al lote')
                            ->lot(fn ($get) => $get('lots') ? ProductLot::find($get('lots')) : null)
                            ->hidden(fn ($get) => $get('lots') == null),

                        TextInput::make('quantity')
                            ->numeric()
                            ->label('Cantidad a fabricar')
                            ->hidden(fn ($get) => $get('lots') == null)
                            ->default(0)
                            ->rules([
                                'required',
                                'numeric',
                                'min:1',
                            ]),

                        ToggleButtons::make('decrementStock')
                            ->label('¿Deseas descontar la cantidad del stock de las partes seleccionadas?')
                            ->boolean()
                            ->grouped()
                            // ->hidden(fn ($get) => $get('lots') == null)
                            ->hidden(fn ($get) => true)
                            ->default(true)
                            ->required(),
                    ]);
            })
            ->modalHeading('Fabricar')
            ->modalDescription('Seleccione la cantidad a fabricar')
            ->slideOver()
            ->modalWidth('xl')
            ->modalContent(fn (Product $record): View => view(
                'filament.resources.products.actions.manufacture',
                ['record' => $record],
            ));
    }
}
