<?php

use Livewire\Volt\Volt;
use App\Livewire\CreateUser;
use App\Livewire\SearchUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::view('/', 'welcome');

Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::view('profile', 'profile')
        ->name('profile');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::get('/users', SearchUser::class)
        ->name('users');
    Route::get('/users/create', CreateUser::class)
        ->name('users.create');
});
