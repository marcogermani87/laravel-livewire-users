<?php

use App\Events\MessageSent;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Chat;
use App\Livewire\User\Create;
use App\Livewire\User\Search;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'welcome');

Route::middleware('guest')->group(function () {
    Volt::route('login', 'pages.auth.login')
        ->name('login');

    if(App::hasDebugModeEnabled()) {
        Volt::route('register', 'pages.auth.register')
            ->name('register');

        Volt::route('forgot-password', 'pages.auth.forgot-password')
            ->name('password.request');

        Volt::route('reset-password/{token}', 'pages.auth.reset-password')
            ->name('password.reset');
    }
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

    Route::get('/users', Search::class)
        ->name('users');

    Route::get('/users/create', Create::class)
        ->name('users.create');

    // Chat Room Route
    Route::get('/chat/{friend}', Chat::class)->name('chat');

    // Get Chat Messages Route
    Route::get('/messages/{friend}', function (User $friend) {
        return ChatMessage::query()
            ->where(function ($query) use ($friend) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $friend->id);
            })
            ->orWhere(function ($query) use ($friend) {
                $query->where('sender_id', $friend->id)
                    ->where('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])
            ->orderBy('id', 'asc')
            ->get();
    });

    // Send Chat Message Route
    Route::post('/messages/{friend}', function (User $friend) {
        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $friend->id,
            'text' => request()->input('message')
        ]);
        broadcast(new MessageSent($message));
        return $message;
    });
});
