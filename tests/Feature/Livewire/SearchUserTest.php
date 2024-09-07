<?php

use App\Livewire\SearchUser;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(SearchUser::class)
        ->assertStatus(200);
});
