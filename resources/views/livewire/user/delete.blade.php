<div>
    <x-mary-button icon="o-trash" class="btn-outline btn-sm text-red-500" wire:click="$toggle('showModal')" />

    @if($showModal)
        <x-mary-modal wire:model="showModal" :title="__('Delete User')" persistent>
            <div>
                {{ __('Are you sure you want to delete') }} <strong>{{ $user->name }}</strong>?
            </div>
            <x-slot:actions>
                <x-mary-button :label="__('Cancel')" wire:click="closeModal()" />
                <x-mary-button :label="__('Delete')" class="btn-error" wire:click="delete()" spinner />
            </x-slot:actions>
        </x-mary-modal>
    @endif
</div>
