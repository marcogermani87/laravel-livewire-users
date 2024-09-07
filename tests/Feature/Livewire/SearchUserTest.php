<?php

use App\Livewire\User\Search;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Search::class)
        ->assertStatus(200);
});
