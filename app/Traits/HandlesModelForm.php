<?php

namespace App\Traits;

use WireUi\Traits\WireUiActions;

trait HandlesModelForm
{
    use WireUiActions;

    public $model;
    
    public array $form = [];

    /**
     * Este método debe ser implementado por cualquier clase que use este trait.
     * Debe devolver una instancia del modelo específico.
     */
    abstract protected function getModelClass();

    /**
     * Este método debe ser implementado por cualquier clase que use este trait.
     * Debe devolver una instancia de la Request para validación.
     */
    abstract protected function getRequestInstance();

    /**
     * Este método debe ser implementado por cualquier clase que use este trait.
     * Debe devolver una instancia del modelo específico.
     */
    abstract protected function getRedirectRoute();
    
    protected function rules()
    {
        return ($this->getRequestInstance())->rules(optional($this->model)->id);
    }

    protected function validationAttributes()
    {
        return ($this->getRequestInstance())->attributes();
    }

    public function mount($model = null)
    {
        // Obtiene el nombre de la clase del modelo
        $modelClass = $this->getModelClass();

        $this->model = $model ? $modelClass::findOrFail($model) : new $modelClass;

        $fill = ($this->getRequestInstance())->fill();

        $this->form = $this->model->only($fill);
    }

    public function submit()
    {
        $this->validate();

        if ($this->model->exists) {

            $this->model->update($this->form);

            $this->notification(__("Successfully updated."));
        } else {
            
            $this->model->create($this->form);

            $this->notification(__("Record created successfully."));
        }

        return $this->redirect(route($this->getRedirectRoute()), navigate: true);
    }
}