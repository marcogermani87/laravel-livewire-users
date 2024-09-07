<?php

namespace App\Livewire\Traits;

trait HasModal
{
    public bool $showModal = false;

    public function closeModal(): void
    {
        $this->showModal = false;
    }
}
