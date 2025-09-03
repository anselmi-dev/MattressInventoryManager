<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use BackedEnum;
use UnitEnum;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\ToggleButtons;

class ConfigurationFormPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Parámetros';

    protected static string | UnitEnum | null $navigationGroup = 'Configuración';

    protected static ?string $title = 'Parámetros';

    protected string $view = 'filament.pages.configuration-form-page';

    public $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function canAccess(array $parameters = []): bool
    {
        return true;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Configuración del Stock')
                ->schema([
                    TextInput::make('stock_days')
                        ->label(__('Number of days of stock'))
                        ->default(settings()->get('stock:days'))
                        ->minValue(1)
                        ->numeric()
                        ->required()
                        ->helperText(__('Days used to calculate the basis for the average of previous sales.')),

                    TextInput::make('stock_media_days')
                        ->label(__('Number of days'))
                        ->default(settings()->get('stock:media:days'))
                        ->minValue(1)
                        ->numeric()
                        ->required()
                        ->helperText(__('Days used for the average of previous sales.')),
                ])
                ->columns(2),
            Section::make('Configuración de la Notificación')
                ->schema([
                    TextInput::make('email')
                        ->label(__('Email'))
                        ->required()
                        ->helperText(__('Email that will be sent with the orders.'))
                        ->unique()
                        ->email()
                        ->default(settings()->get('order:email')),
                    ToggleButtons::make('notification')
                        ->label(__('Notification'))
                        ->boolean()
                        ->grouped()
                        ->default(settings()->get('notification'))
                        ->required(),
                ]),

        ])
        ->columns(2)
        ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('submit')
                ->submit('submit')
                ->label(__('Guardar'))
                ->icon('heroicon-o-check')
                ->color('success')
        ];
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        settings()->set('order:email', $data['email']);

        settings()->set('notification', $data['notification']);

        settings()->set('stock:media:days', $data['stock_media_days']);

        settings()->set('stock:days', $data['stock_days']);

        Artisan::call('queue:restart');

        Cache::flush('alert:warning:stock');

        Cache::flush('alert:danger:stock');

        Notification::make()
            ->success()
            ->title(__('Configuración actualizada correctamente!'))
            ->send();
    }
}
