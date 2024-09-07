<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public $name = '';

    public $email = '';

    public $password = '';

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
        ];
    }
}
