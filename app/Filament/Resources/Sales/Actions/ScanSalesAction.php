<?php

namespace App\Filament\Resources\Sales\Actions;

use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ScanSalesAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name)
            ->label('Escanear Ventas')
            ->icon('heroicon-o-arrow-path')
            ->color('primary')
            ->action(function (array $data) {
                try {

                    $command = 'app:scan-sales';

                    $arguments = [];

                    if (!empty($data['code'])) {
                        $arguments['--code'] = $data['code'];
                    }

                    $exitCode = Artisan::call($command, $arguments);

                    $output = Artisan::output();

                    if ($exitCode === 0) {
                        Notification::make()
                            ->title('Sincronización completada')
                            ->body('Las ventas se han sincronizado correctamente desde Factusol.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Error en la sincronización')
                            ->body('Hubo un error al sincronizar las ventas. Revisa los logs para más detalles.')
                            ->danger()
                            ->send();
                    }

                    // Log the output for debugging
                    Log::info('ScanSales Command Output: ' . $output);

                } catch (\Exception $e) {
                    Log::error('Error executing ScanSales command: ' . $e->getMessage());

                    Notification::make()
                        ->title('Error en la sincronización')
                        ->body('Error: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->schema(function ($schema) {
                $schema->components([
                    TextInput::make('code')
                        ->label('Código de factura')
                        ->placeholder('Opcional: Buscar por código específico')
                        ->helperText('Deja vacío para sincronizar todas las ventas'),
                ]);

                return $schema;
            })
            ->modalHeading('Sincronizar Ventas desde Factusol')
            ->slideOver()
            ->modalWidth('xl')
            ->modalDescription('Ejecuta el comando de sincronización para obtener las ventas más recientes de Factusol.')
            ->modalSubmitActionLabel('Ejecutar Sincronización')
            ->modalCancelActionLabel('Cancelar');
    }
}
