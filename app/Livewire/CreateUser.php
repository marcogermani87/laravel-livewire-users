<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use LivewireUI\Modal\ModalComponent;

class CreateUser extends ModalComponent
{
    public UserForm $form;

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function save()
    {
        $this->validate();

//        $validated = $this->validate([
//            'name' => 'required',
//            'email' => 'required|email:rfc,dns',
//            'password' => ['required', Password::min(8)
//                ->letters()
//                ->mixedCase()
//                ->numbers()
//                ->symbols()],
//        ]);

        $formData = $this->form->all();

        $formData['email_verified_at'] = Carbon::now();
        $formData['password'] = Hash::make($formData['password']);
        $formData['remember_token'] = Str::random(10);

        User::create($formData);

        session()->flash('created', 'User successfully created.');

        /*$this->closeModalWithEvents([
            SearchUser::class => 'userCreated',
        ]);*/

        return $this->redirect('/users', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.create-user');
    }
}
