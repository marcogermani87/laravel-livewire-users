<div>
    <x-mary-button icon="o-trash" class="btn-outline btn-sm text-red-500" wire:click="$toggle('showModal')" />

    @if($showModal)
        <x-mary-modal wire:model="showModal" persistent>
            <div>Are you sure?</div>
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.showModal = false"/>
                <x-mary-button label="Delete" class="btn-error" wire:click="delete({{ $id }})" spinner />
            </x-slot:actions>
        </x-mary-modal>
    @endif
</div>
