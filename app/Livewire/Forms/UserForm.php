<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class UserForm extends Form
{
    public $name = '';

    public $email = '';

    public $password = '';

    public function rules(): array
    {
        return [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|max:255',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];
    }
}
