<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Livewire\Forms\UserForm;

class Delete extends Component
{
    public int $id;

    public bool $showModal = false;

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        session()->flash('success-message', 'User successfully deleted.');

        return $this->redirect('/users', navigate: true);
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.user.delete');
    }
}
