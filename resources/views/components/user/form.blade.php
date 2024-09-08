@props(['title', 'id' => 'create'])

<x-mary-form wire:submit="save">

    <h2 class="text-base dark:text-white font-semibold leading-7 text-gray-900 border-b pb-2">{{ $title }}</h2>

    <x-mary-input :label="__('Name')" wire:model="form.name" />

    <x-mary-input :label="__('E-mail')" wire:model="form.email" type="email" />

    <x-mary-input :label="__('Password')" wire:model="form.password" type="password" />

    <x-slot:actions>
        <x-mary-button wire:click="closeModal()" :label="__('Close')" class="btn-outline btn-sm" />
        <x-mary-button wire:submit class="btn-primary btn-sm" :label="__('Save')" type="submit" spinner="save" />
    </x-slot:actions>

</x-mary-form>
