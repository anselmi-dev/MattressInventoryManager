<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Models\Order;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Orders\Actions\OrderReceptionConfirmationAction;
use App\Filament\Resources\Orders\Actions\ConfirmOrderShipmentAction;
use App\Filament\Resources\Orders\Actions\RetrunIndexAction;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_email')
                ->label(__('Confirmar envío'))
                ->visible(fn (Order $record) => $record->getIsPendingAttribute())
                ->action(function (Order $record) {
                    try {
                        $record->sendEmail();

                        Notification::make()
                            ->title('Success')
                            ->body('El envío ha sido confirmado')
                            ->success()
                            ->send();

                    } catch (\Throwable $th) {

                        Notification::make()
                            ->title('Error')
                            ->body($th->getMessage())
                            ->send();
                    }
                }),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        $schema = static::getResource()::form($schema);

        $schema->getComponent('order_products')
            ->addable(false)
            ->deletable(false)
            ->reorderable(false)
            ->columns(2)
            ->reactive(false)
            ->disabled(fn (Order $record) => !$record->getIsPendingAttribute())
            ->schema([
                Select::make('product_id')
                    ->label(__('filament.resources.product'))
                    ->relationship(
                        name: 'product',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->withoutGlobalScopes()->withTrashed()
                    )
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return new HtmlString("<b>{$record->code}</b> <br> <b>{$record->name}</b>");
                    })
                    ->allowHtml()
                    ->searchable()
                    ->required(),

                TextInput::make('quantity')
                    ->label(__('filament.resources.quantity'))
                    ->numeric()
                    ->minValue(1)
                    ->required(),
            ]);

        $schema->getComponent('message')->visible(fn (Order $record) => $record->getIsPendingAttribute());

        $schema->getComponent('email')->visible(fn (Order $record) => $record->getIsPendingAttribute());

        return $schema;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            ConfirmOrderShipmentAction::make(),
            OrderReceptionConfirmationAction::make(),
            RetrunIndexAction::make(),
        ];
    }

}
