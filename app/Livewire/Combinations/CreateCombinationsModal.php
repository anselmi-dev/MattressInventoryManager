<?php

namespace App\Livewire\Combinations;

use App\Models\Combination;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\DB;

class CreateCombinationsModal extends ModalComponent
{
    public Combination $combination;

    public int $quantity;

    public bool $confirm = false;

    public function rules ()
    {
        return [
            'quantity' => 'required|integer|min:1',
            'confirm' => 'required|accepted'
        ];
    }

    protected function messages ()
    {
        return [
            'confirm.accepted' => __('You must confirm the operation'),
        ];
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public static function closeModalOnEscapeIsForceful(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
    
    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public function mount(Combination $combination)
    {
        $this->combination = $combination;
    }

    public function render()
    {
        return view('livewire.combinations.create-combinations-modal');
    }

    public function submit()
    {
        $this->validate();
        
        $minStock = $this->combination->products()->min('stock');

        if ($this->quantity > $minStock) {
            $this->addError('quantity', __('The quantity must be equal to or less than :quantity', ['quantity' => $minStock]));
            return;
        }
    
        $this->combination->manufacture($this->quantity);

        $this->dispatch('after:combinations:manufacture');
        
        $this->closeModal();
    }
}
