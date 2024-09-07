@php
    $label = "Update User";
@endphp
<div>
    <x-mary-button icon="o-pencil-square" class="btn-outline btn-sm" wire:click="$toggle('showModal')"/>

    @if($showModal)
        <x-mary-modal wire:model="showModal" persistent>
            <x-user.form :title="$label" :id="$id"/>
        </x-mary-modal>
    @endif
</div>
