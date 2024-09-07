<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    @if (session('success-message'))
        <x-mary-alert
            icon="o-check" class="alert-success mb-3"
            x-data="{ show: true }" x-init="setTimeout(() => {show = false}, 10000)" x-show="show" dismissible
        >
            {{ session('success-message') }}
        </x-mary-alert>
    @endif
    <x-mary-card class="py-6 px-12" x-init="setInterval(() => {$wire.$refresh()}, 10000)">
        <div class="sm:flex sm:flex-col sm:items-end mb-3">
            <livewire:create-user/>
        </div>
        <x-mary-input wire:model.live="search" placeholder="Search user for login or name..."
                      class="border-2 border-indigo-500/100 rounded-md w-full p-2 mb-3"/>
        @foreach ($users as $user)
            <x-mary-list-item :item="$user">
                <x-slot:avatar>
                    <x-mary-avatar
                        :image="'https://ui-avatars.com/api/?size=128&background=random&name=' . urlencode($user->name)"
                        class="!w-14"/>
                </x-slot:avatar>
                <x-slot:value>
                    {{ $user->name }}
                </x-slot:value>
                <x-slot:sub-value>
                    {{ $user->email }}
                </x-slot:sub-value>
                <x-slot:actions>
                    <x-mary-button
                        icon="o-trash"
                        class="btn-outline btn-sm text-red-500"
                        wire:click="delete({{ $user->id }})"
                        wire:confirm="Are you sure you want to delete this user?"
                        spinner
                    />
                </x-slot:actions>
            </x-mary-list-item>
        @endforeach
        @if( !empty($search) && count($users) <= 0)
            <x-mary-alert icon="o-information-circle" class="alert-info mt-3">
                No users found!
            </x-mary-alert>
        @endif
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </x-mary-card>
</div>
