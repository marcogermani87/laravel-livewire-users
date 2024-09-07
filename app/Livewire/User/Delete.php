<?php

namespace App\Livewire\User;

use App\Livewire\Traits\HasModal;
use App\Models\User;
use Livewire\Component;

class Delete extends Component
{
    use HasModal;

    public int $id;

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        session()->flash('success-message', 'User successfully deleted.');

        return $this->redirect('/users', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.delete');
    }
}
