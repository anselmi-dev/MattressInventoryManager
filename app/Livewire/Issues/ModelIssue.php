<?php

namespace App\Livewire\Issues;

use Livewire\Component;

class ModelIssue extends Component
{
    protected $listeners = [
        'issue:delete' => 'delete'
    ];

    public function render()
    {
        return view('livewire.issues.model-issue');
    }
}
