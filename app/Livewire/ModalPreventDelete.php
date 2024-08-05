<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class ModalPreventDelete extends ModalComponent
{

    public $model_id;

    public $emit;

    public function mount(int $model_id, string $emit)
    {
        $this->model_id = $model_id;

        $this->emit = $emit;
    }

    public function render()
    {
        return view('livewire.modal-prevent-delete');
    }

    public function submit()
    {
        $this->dispatch($this->emit, id: $this->model_id);

        $this->closeModal();
    }
}
