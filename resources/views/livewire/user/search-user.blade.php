<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    @if (session('created'))
        <div
            x-data="{ show: true }" x-init="setTimeout(() => {show = false}, 5000)" x-show="show"
            class="message-box border border-green-600 bg-green-600/10 rounded-md w-full p-6 mb-3 font-medium text-white">
            {{ session('created') }}
        </div>
    @endif
    @if (session('deleted'))
        <div x-data="{ show: true }" x-init="setTimeout(() => {show = false}, 5000)" x-show="show"
             class="message-box border border-red-600 bg-red-600/10 rounded-md w-full p-6 mb-3 font-medium text-white">
            {{ session('deleted') }}
        </div>
    @endif
    <div class="bg-white px-4 py-12 sm:px-6 lg:px-8 shadow-sm sm:rounded-lg">
        <div class="mx-auto max-w-4xl">
            <div class="sm:flex sm:flex-col sm:items-end mb-3">
                <button wire:click="$dispatch('openModal', { component: 'create-user' })"
                   class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    New User
                </button>
            </div>
            <input wire:model.live="search" placeholder="Search for login or name"
                   class="border-2 border-indigo-500/100 rounded-md w-full p-2">
            <ul role="list" class="divide-y divide-gray-100">
                @foreach ($users as $user)
                    <li class="flex justify-between gap-x-6 py-5" wire:key="user-{{ $user->id }}">
                        <div class="flex min-w-0 gap-x-4">
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                 src="https://ui-avatars.com/api/?size=128&background=random&name={{ urlencode($user->name) }}"
                                 alt="">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">{{ $user->name }}</p>
                                <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <button
                                type="button"
                                class="rounded-md bg-red-600 px-2 py-1 text-sm font-semibold text-white shadow-sm hover:bg-red-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                wire:click="delete({{ $user->id }})"
                                wire:confirm="Are you sure you want to delete this user?"
                            >
                                Delete
                            </button>
                        </div>
                    </li>
                @endforeach
                @if( !empty($search) && count($users) <= 0)
                    <div class="border border-sky-500 bg-sky-500/10 rounded-md w-full p-6 mt-3 font-medium">
                        No users found!
                    </div>
                @endif
            </ul>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
