<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

Artisan::command('demo:refresh', function () {
    $this->call('down');
    Log::info("Executed Application down", ['command' => $this->signature]);
    $this->call('migrate:fresh', [
        '--seed' => true,
    ]);
    Log::info("Executed DB fresh and seed", ['command' => $this->signature]);
    $this->call('up');
    Log::info("Executed Application up", ['command' => $this->signature]);
})->purpose('Prune and refresh all demo data')
    ->everyThirtyMinutes();
