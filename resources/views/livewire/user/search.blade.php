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
    <x-mary-card class="py-6 px-12" wire:poll.15s>
        <div class="sm:flex sm:flex-col sm:items-end mb-3">
            <livewire:user.create/>
        </div>
        <div class="mb-3">
            <x-mary-input
                wire:model.live="search"
                placeholder="Search user for e-mail or name..."
                autocomplete="off"
                clearable
            />
        </div>
        @foreach ($users as $user)
            @php
                $isYou = auth()->user()->id === $user->id;
            @endphp
            <x-mary-list-item :item="$user" wire:key="user-list-item-{{ $user->id }}">
                <x-slot:avatar>
                    <x-mary-avatar
                        :image="'https://ui-avatars.com/api/?size=128&background=random&name=' . urlencode($user->name)"
                        class="!w-14"/>
                </x-slot:avatar>
                <x-slot:value>
                    {{ $user->name }}
                </x-slot:value>
                <x-slot:sub-value>
                    {{ $user->email }} @if($isYou)
                        <x-mary-badge value="You" class="ml-2 badge-info"/>
                    @endif
                </x-slot:sub-value>
                <x-slot:actions>
                    @if(!$isYou)
                        <livewire:user.edit :id="$user->id" wire:key="user-edit-{{ $user->id }}"/>
                        <livewire:user.delete :id="$user->id" wire:key="user-delete-{{ $user->id }}"/>
                    @else
                        <x-mary-button
                            icon="o-pencil-square"
                            class="btn-outline btn-sm"
                            link="{{ route('profile') }}"
                            wire:navigate
                        />
                    @endif
                </x-slot:actions>
            </x-mary-list-item>
        @endforeach
        @if( !empty($search) && count($users) <= 0)
            <div class="mt-5">
                <x-mary-alert icon="o-information-circle" class="alert-info">
                    No users found!
                </x-mary-alert>
            </div>
        @endif
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </x-mary-card>
</div>
