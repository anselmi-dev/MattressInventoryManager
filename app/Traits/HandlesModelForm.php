<?php

namespace App\Traits;

use App\Models\Code;
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
        $code = ($this->model)->code;

        return ($this->getRequestInstance())->rules(optional($code)->id);
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

        if ($this->model->code) {
            $this->form['code'] = $this->model->code->value;
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->model->exists) {
            $this->model->update($this->form);
            
            if ($this->form['code']) {
                $this->model->code->value = $this->form['code'];
                $this->model->code->save();
            }

            $this->notification(__("Successfully updated."));
        } else {
            
            $model = $this->model->create($this->form);
            
            if ($this->form['code']) {
                $model->code()->create(['value' => $this->form['code']]);
            }

            $this->notification(__("Se creó correctamente."));
        }

        return $this->redirect(route($this->getRedirectRoute()), navigate: true);
    }
}