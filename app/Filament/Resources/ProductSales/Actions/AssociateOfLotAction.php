<?php


namespace App\Filament\Resources\ProductSales\Actions;

use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use App\Models\ProductLot;
use App\Models\ProductSale;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class AssociateOfLotAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->icon('heroicon-o-pencil')
            ->action(function (array $data, ProductSale $record) {

                $record->product_lot_id = $data['product_lot_id'];

                $record->save();

                Notification::make()
                    ->title('Asociación exitosa')
                    ->success()
                    ->send();
            })
            ->schema(function ($schema, $record) {

                $schema->components([
                    Select::make('product_lot_id')
                        ->label('Lote')
                        ->relationship(name: 'product_lot', titleAttribute: 'name', modifyQueryUsing: fn (Builder $query) => $query->whereIsPart()->when($record->product, function (Builder $query) use ($record) {
                            $query->where('reference', $record->product->reference);
                        })->orderBy('name', 'asc'))
                        ->getOptionLabelFromRecordUsing(function (Model $record) {
                            return new HtmlString("<b>{$record->name}</b> <br> {$record->product->name}");
                        })
                        ->allowHtml()
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->default($record->product_lot_id)
                        ->required(),
                ]);

                return $schema;
            })
            ->modalHeading('Asociar lote')
            ->slideOver()
            ->modalWidth('xl')
            ->modalContent(fn (ProductSale $record): View => view(
                'filament.resources.product-sales.actions.associate-of-lot',
                ['record' => $record],
            ));
    }
}
