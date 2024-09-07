<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SearchUser extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        session()->flash('deleted', 'User successfully deleted.');
    }

    public function render()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $query->where('email', 'like', "%$this->search%")
                ->orwhere('name', 'like', "%$this->search%");
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user.search-user', [
            'users' => $users,
        ]);
    }
}
