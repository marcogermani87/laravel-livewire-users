<?php

namespace App\Livewire\User;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public UserForm $form;

    public bool $showModal = false;

    public function save()
    {
        $this->validate();

        $formData = $this->form->all();

        $formData['email_verified_at'] = Carbon::now();
        $formData['password'] = Hash::make($formData['password']);
        $formData['remember_token'] = Str::random(10);

        User::create($formData);

        session()->flash('success-message', 'User successfully created.');

        return $this->redirect('/users', navigate: true);
    }

    public function closeModal()
    {
        $this->showModal= false;
        $this->form->clearValidation();
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
