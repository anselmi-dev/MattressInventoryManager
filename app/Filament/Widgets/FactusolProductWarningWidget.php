<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class FactusolProductWarningWidget extends Widget
{
    /**
     * @var view-string
     */
    protected string $view = 'filament.widgets.factusol-product-warning';

    protected static bool $isLazy = false;

    /**
     * @var int | string | array<string, int | null>
     */
    protected int | string | array $columnSpan = 'full';

    public ?Model $record = null;

    public ?bool $hasFactusolProduct = false;

    public static function canView(): bool
    {
        try {
            $livewire = app('livewire')->current();

            $record = $livewire->record;

            if (!$record instanceof Product) {
                return false;
            }

            return !$record->factusolProduct()->exists();

        } catch (\Exception $e) {

            return false;
        }
    }

    protected function getActions(): array
    {
        return [
            Action::make('sync_factusol')
                ->label('Sincronizar con Factusol')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->action('syncWithFactusol')
                ->requiresConfirmation()
                ->modalHeading('Sincronizar con Factusol')
                ->modalDescription('¿Estás seguro de que quieres intentar sincronizar este producto con Factusol?')
                ->modalSubmitActionLabel('Sincronizar')
        ];
    }

    public function syncWithFactusol(): void
    {
        try {

            $product = $this->record;

            Artisan::call('app:scan-products', [
                '--code' => $product->code,
                '--force' => true
            ]);

            $this->hasFactusolProduct = $product->factusolProduct()->exists();

            Notification::make()
                ->title($this->hasFactusolProduct ? 'Sincronización exitosa' : 'Sincronización incompleta')
                ->body(
                    $this->hasFactusolProduct ?
                    "El producto '{$product->code}' se ha sincronizado correctamente con Factusol." :
                    "El producto '{$product->code}' no se ha sincronizado correctamente con Factusol.")
                ->status($this->hasFactusolProduct ? 'success' : 'warning')
                ->send();

            $this->dispatch('refreshRelation');

        } catch (\Exception $e) {
            report($e);

            Notification::make()
                ->title('Error de sincronización')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
