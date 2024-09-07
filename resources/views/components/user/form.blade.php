@props(['title', 'id' => 'create'])

<x-mary-form wire:submit="save">

    <h2 class="text-base dark:text-white font-semibold leading-7 text-gray-900 border-b pb-2">{{ $title }}</h2>

    <x-mary-input label="Name" wire:model="form.name" />

    <x-mary-input label="E-mail" wire:model="form.email" type="email" />

    <x-mary-input label="Password" wire:model="form.password" type="password" />

    <x-slot:actions>
        <x-mary-button wire:click="closeModal()" label="Close" class="btn-outline btn-sm" />
        <x-mary-button wire:submit class="btn-primary btn-sm" label="Save" type="submit" spinner="save" />
    </x-slot:actions>

</x-mary-form>
