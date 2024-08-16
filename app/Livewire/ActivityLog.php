<?php

namespace App\Livewire;

use Livewire\Component;

use Spatie\Activitylog\Models\Activity as Model;
use WireUi\Traits\WireUiActions;

class ActivityLog extends Component
{
    use WireUiActions;

    // protected $model = Model::class;

    protected $listeners = [
    ];

    public function render()
    {
        return view('livewire.activity-log', [
            'collection' => Model::paginate(30)
        ]);
    }
}
