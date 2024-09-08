<?php

namespace App\Livewire\User;

use App\Livewire\Traits\HasModal;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use App\Livewire\Forms\UserForm;

class Edit extends Component
{
    use HasModal;

    public int $id;

    public User $user;

    public UserForm $form;

    public function mount()
    {
        $this->user = User::query()
            ->findOrFail($this->id);

        $this->form->fill($this->user);
    }

    public function save()
    {
        $rules = $this->form->rules();

        $rules['email'] = [
            'required',
            'email:rfc',
            'max:255',
            Rule::unique('users', 'email')
                ->ignore($this->user->email, 'email'),
        ];

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

        session()->flash('success-message', __('User successfully updated.'));

        return $this->redirect('/users', navigate: true);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->form->reset('password');
        $this->form->clearValidation();
    }

    public function render()
    {
        return view('livewire.user.edit');
    }
}
