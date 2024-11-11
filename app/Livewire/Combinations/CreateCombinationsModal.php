<?php

namespace App\Livewire\Combinations;

use App\Models\Product as Model;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\DB;

class CreateCombinationsModal extends ModalComponent
{
    public Model $combination;

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

    public function mount(Model $combination)
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
        
        $minStock = (int) $this->combination->combinedProducts()->min('stock');

        if ($this->combination->combinedProducts()->doesntExist()) {
            $this->addError('parts', __('La combinación no tiene partes asociadas. Por favor, revisa y asocia las partes correspondientes a la combinación.'));
            return;
        } elseif ($minStock == 0) {
            $this->addError('parts', __('Las partes no poseen suficiente Stock para crear la combinación.'));
            return;
        } elseif ($this->quantity < 0) {
            $this->addError('quantity', __('La cantidad no puede ser menor a 1'));
            return;
        } elseif ($this->quantity > $minStock) {
            $this->addError('quantity', __('The quantity must be equal to or less than :quantity', ['quantity' => $minStock]));
            return;
        }
    
        $this->combination->manufacture($this->quantity);

        $this->dispatch('after:combinations:manufacture');
        
        $this->closeModal();
    }
}
