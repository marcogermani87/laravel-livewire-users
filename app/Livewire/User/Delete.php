<?php

namespace App\Livewire\User;

use App\Livewire\Traits\HasModal;
use App\Models\User;
use Livewire\Component;

class Delete extends Component
{
    use HasModal;

    public User $user;

    public function delete()
    {
        $user = User::findOrFail($this->user->id);

        $user->delete();

        session()->flash('success-message', __('User successfully deleted.'));

        return $this->redirect('/users', navigate: true);
    }

    public function render()
    {
        return view('livewire.user.delete');
    }
}
