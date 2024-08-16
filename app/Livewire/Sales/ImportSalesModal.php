<?php

namespace App\Livewire\Sales;

use App\Imports\SalesImport;
use LivewireUI\Modal\ModalComponent;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Maatwebsite\Excel\Facades\Excel;
use WireUi\Traits\WireUiActions;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportSalesModal extends ModalComponent
{
    use WithFileUploads, WireUiActions;
    
    public $file;

    public function rules ()
    {
        return [
            'file' => 'file|max:1024'
        ];
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'xl';
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

    protected function validationAttributes()
    {
        return [
            'file' => __('File')
        ];
    }

    public function render()
    {
        return view('livewire.sales.import-sales-modal');
    }

    public function submit()
    {
        $this->validate();

        try {
            
            Excel::import(new SalesImport, $this->file->storeAs('public', sha1(time()) . '.csv'), null, \Maatwebsite\Excel\Excel::XLSX);
        
        } catch (ValidationException $e) {

            $failures = $e->failures();

            $rows = [];

            foreach ($failures as $failure) {
                $rows[] = $failure->errors()[0];
            }

            $this->dialog()->warning(
                'El proceso de importación se ha completado, pero se han detectado algunos errores en el archivo CSV que requieren corrección.',
                view('responses.dialog-errors', ['warning' => $rows])->render()
            );
        }

        $this->closeModal();

        \App\Jobs\ProcessPendingSales::dispatch();
        
        $this->dispatch('sales:refresh-datatable');
    }
}
