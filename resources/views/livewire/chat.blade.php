<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8" id="app">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat with') }} "{{ $friend->name }}"
        </h2>
    </x-slot>
    <x-mary-card class="py-6 px-12">
        <chat-room
            :friend="{{ $friend }}"
            :current-user="{{ auth()->user() }}"
        />
    </x-mary-card>
</div>
