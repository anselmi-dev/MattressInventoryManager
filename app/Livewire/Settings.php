<?php

namespace App\Livewire;

use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class Settings extends Component
{
    use WireUiActions;

    public string $email = '';
    
    public int|string|null $stock_days = 0;

    public int|string|null $stock_media_days = 0;
    
    public bool $notification = true;
    
    public function rules ()
    {
        return [
            'stock_days' => 'required|integer|min:1',
            'stock_media_days' => 'required|integer|min:1',
            'notification' => 'required|bool',
            'email' => 'required|email',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'stock_days' => __('Number of days'),
            'stock_media_days' => __('Number of days of stock'),
            'notification' => __('Notification'),
            'email' => __('Email'),
        ];
    }

    public function mount ()
    {
        $this->email = settings()->get('order:email', 'anselmi@infinety.es');

        $this->stock_media_days = settings()->get('stock:media:days');

        $this->stock_days = settings()->get('stock:days');

        $this->notification = (int) settings()->get('notification', true);
    }

    public function render()
    {
        return view('livewire.settings');
    }

    public function submit()
    {
        $this->validate();

        settings()->set('order:email', $this->email);

        settings()->set('notification', $this->notification);

        settings()->set('stock:media:days', $this->stock_media_days);

        settings()->set('stock:days', $this->stock_days);

        Artisan::call('queue:restart');

        Cache::flush('alert:warning:stock');

        Cache::flush('alert:danger:stock');

        $this->notification()->success(
            __('Los cambios han sido guardados exitosamente.'),
        );
    }
}
