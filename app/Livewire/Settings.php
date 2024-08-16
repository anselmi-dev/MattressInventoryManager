<?php

namespace App\Livewire;

use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class Settings extends Component
{
    use WireUiActions;

    public int $alert_danger = 0;

    public int $alert_warning = 0;

    public bool $notification = true;
    
    public function mount ()
    {
        $this->alert_danger = settings()->get('alert:danger', 50);

        $this->alert_warning = (int) settings()->get('alert:warning', 100);

        $this->notification = (int) settings()->get('notification', true);
    }

    public function render()
    {
        return view('livewire.settings');
    }

    public function submit()
    {
        settings()->set('notification', $this->notification);

        settings()->set('alert:danger', (int) $this->alert_danger);

        settings()->set('alert:warning', (int) $this->alert_warning);

        Artisan::call('queue:restart');

        Cache::flush('alert:warning:stock');

        Cache::flush('alert:danger:stock');

        $this->notification()->success(
            __('Los cambios han sido guardados exitosamente.'),
        );
    }
}
