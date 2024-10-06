<?php

namespace App\Livewire\Issues;

use App\Http\Requests\IssueRequest as RequestModel;
use App\Models\Issue;
use LivewireUI\Modal\ModalComponent;
use App\Models\Sale as Model;
use App\Traits\HandlesModelForm;
use Exception;

class CreateIssuesModal extends ModalComponent
{
    use HandlesModelForm;

    public $file;

    protected function getRedirectRoute()
    {
        
    }

    protected function getModelClass()
    {
        return Model::class;
    }

    protected function getRequestInstance()
    {
        return new RequestModel($prefix = 'form');
    }

    protected function rules()
    {
        return ($this->getRequestInstance())->rules();
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

    public function mount($model = null)
    {
        // Obtiene el nombre de la clase del modelo
        $modelClass = $this->getModelClass();

        $this->model = $model ? $modelClass::findOrFail($model) : new $modelClass;

        $fill = ($this->getRequestInstance())->fill();

        $this->form = $this->model->only($fill);

        if ($this->model->exists) {
            $this->form['sale_id'] = $this->model->id;
        }

        $issue = $this->model->issues()->first();
        if ($issue) {
            $this->form['id'] = $issue->id;

            $this->form['note'] = $issue->note;

            $this->form['type'] = $issue->type;
            
            $this->form['created_at'] = $issue->created_at;
        }
    }

    public function render()
    {
        return view('livewire.issues.create-issues-modal');
    }

    public function submit()
    {
        $this->validate();

        try {

            if (isset($this->form['id'])) {
                Issue::where('id', $this->form['id'])->update($this->form);
                $this->notification(__("Record created successfully."));
            } else {
                $this->model->issues()->create($this->form);
                $this->notification(__("Record created successfully."));
            }
            
            $this->dispatch('sales:refresh-datatable');
            
            $this->closeModal();

        } catch (Exception $e) {
            $this->notification()->error($e->getMessage());
        }

    }

    public function getTypesProperty()
    {
        return [
            [
                'id' => 'broken',
                'label' => __('Broken')
            ],
            [
                'id' => 'stained',
                'label' => __('Stained')
            ],
            [
                'id' => 'other',
                'label' => __('Other')
            ],
        ];
    }
}
