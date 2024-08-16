<?php

namespace App\Livewire\Users;

use Livewire\Component;

use App\Models\User as Model;
use App\Http\Requests\UserRequest as RequestModel;
use App\Traits\HandlesModelForm;
use Illuminate\Support\Facades\Hash;

class ModelUser extends Component
{
    use HandlesModelForm;

    protected function getModelClass()
    {
        return Model::class;
    }

    protected function getRequestInstance()
    {
        return new RequestModel($prefix = 'form');
    }
    
    protected function getRedirectRoute()
    {
        return 'users.index';
    }

    public function render()
    {
        return view('livewire.users.model-user');
    }

    protected function rules()
    {
        return ($this->getRequestInstance())->rules(optional($this->model)->id);
    }

    public function submit()
    {
        $this->validate();

        if ($this->model->exists) {
            
            $this->model->update($this->form);
            
            $this->notification(__("Successfully updated."));

        } else {
            $user = Model::create([
                'email' => $this->form['email'],
                'name' => $this->form['name'],
                'password' => Hash::make($this->form['password']),
                'email_verified_at' => now(),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'profile_photo_path' => null,
                'current_team_id' => null,
            ]);
    
            $user->assignRole('operator');

            $this->notification(__("Se creó correctamente."));
        }

        return $this->redirect(route($this->getRedirectRoute()), navigate: true);
    }
}
