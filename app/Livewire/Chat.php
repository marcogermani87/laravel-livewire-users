<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Chat extends Component
{
    public User $friend;

    public function mount()
    {
        if ($this->friend->id === auth()->user()->id) {
            return $this->redirect('/users', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
