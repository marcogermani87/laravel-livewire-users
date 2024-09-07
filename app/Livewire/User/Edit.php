<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use App\Livewire\Forms\UserForm;

class Edit extends Component
{
    public int $id;

    public User $user;

    public UserForm $form;

    public bool $showModal = false;

    public function mount()
    {
        $this->user = User::query()
            ->findOrFail($this->id);

        $this->form->fill($this->user);
    }

    public function save()
    {
        $rules = $this->form->rules();

        $rules['password'] = [
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ];

        $this->form->validate($rules);

        $formData = $this->form->all();

        $this->user->update($formData);

        session()->flash('success-message', 'User successfully updated.');

        return $this->redirect('/users', navigate: true);
    }

    public function closeModal()
    {
        $this->showModal= false;
    }

    public function render()
    {
        return view('livewire.user.edit');
    }
}
